<?php

namespace App\Middlewares;

/**
 * Class CsrfMiddleware
 *
 * Middleware for handling CSRF protection for POST requests.
 */
class CsrfMiddleware
{
    /**
     * Checks if a valid CSRF token is provided on POST requests.
     * If the token is missing or invalid, returns a 403 JSON response and stops execution.
     *
     * @return void
     */
    public static function check(): void
    {
        // Only apply CSRF validation to POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Attempt to retrieve token from form or custom header
        $token = $_POST['csrf_token']
            ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

        // If token is invalid, block request
        if (!self::validate($token)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => true,
                'message' => 'Invalid CSRF token.'
            ]);
            exit;
        }
    }

    /**
     * Validates the token using session-stored value and hash_equals.
     *
     * @param string $token The token provided by the client.
     * @return bool True if the token is valid and matches the session token.
     */
    private static function validate(string $token): bool
    {
        return isset($_SESSION['csrf_token']) &&
            hash_equals($_SESSION['csrf_token'], $token);
    }
}
