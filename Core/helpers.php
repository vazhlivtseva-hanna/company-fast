<?php

/**
 * Generates a CSRF token and stores it in the session if not already present.
 *
 * @return string The generated or existing CSRF token.
 */
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validates the CSRF token by comparing it to the one stored in the session.
 *
 * @param string $token The token to validate.
 * @return bool True if the token is valid; otherwise false.
 */
function validateCsrfToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Resolves a class and automatically instantiates it along with its dependencies.
 *
 * Uses ReflectionClass to inspect constructor and recursively resolve dependencies.
 *
 * @param string $class Fully qualified class name (e.g., App\Services\MyService).
 * @return object An instance of the requested class with its dependencies injected.
 * @throws Exception If the class file is not found or a parameter can't be resolved.
 */
function resolve(string $class)
{
    // Convert namespace to relative path
    $relativeClass = str_replace('App\\', '', $class);
    $relativePath = str_replace('\\', '/', $relativeClass);

    $fullPath = __DIR__ . '/../' . $relativePath . '.php';

    // Check file existence
    if (!file_exists($fullPath)) {
        throw new \Exception("Class file for {$class} not found at: {$fullPath}");
    }

    require_once $fullPath;

    // Use reflection to handle constructor dependencies
    $reflection = new \ReflectionClass($class);
    $constructor = $reflection->getConstructor();

    // If no constructor, instantiate directly
    if (!$constructor) {
        return new $class();
    }

    // Resolve constructor parameters recursively
    $params = $constructor->getParameters();
    $dependencies = [];

    foreach ($params as $param) {
        $paramClass = $param->getType()?->getName();
        if (!$paramClass) {
            throw new \Exception("Cannot resolve non-class parameter \${$param->getName()} in $class");
        }
        $dependencies[] = resolve($paramClass);
    }

    return $reflection->newInstanceArgs($dependencies);
}

/**
 * Checks if the currently authenticated user has admin privileges.
 *
 * Assumes user roles are stored as JSON in $_SESSION['user']['roles'].
 *
 * @return bool True if the user has the "ROLE_ADMIN" role; false otherwise.
 */
function isAdmin(): bool
{
    if (!isset($_SESSION['user']['roles'])) {
        return false;
    }

    $roles = json_decode($_SESSION['user']['roles'], true);
    return in_array('ROLE_ADMIN', $roles);
}
