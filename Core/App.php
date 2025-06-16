<?php

namespace App\Core;

use App\Middlewares\CsrfMiddleware;

/**
 * Class App
 *
 * The main application class responsible for routing and controller execution.
 */
class App
{
    protected object $controller;
    protected string $method;
    protected array $params = [];
    protected array $routes = [];

    /**
     * App constructor.
     *
     * Parses the URL, determines controller & method based on the route,
     * and invokes the action.
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        session_start();

        $urlParts = $this->parseUrl();

        // Determine route base from URL
        $routeBase = $urlParts[0] ?? 'dashboard';
        if (isset($urlParts[1])) {
            $routeBase .= '/' . $urlParts[1];
        }

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $routeKey = strtolower($routeBase . '.' . $requestMethod);

        $publicRoutes = ['login.get', 'login.post', 'register.get', 'register.post'];

        // Redirect to login if user is not authenticated
        if (!in_array($routeKey, $publicRoutes) && !isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // Route not found
        if (!isset($this->routes[$routeKey])) {
            http_response_code(404);
            echo "404 - Route Not Found!";
            return;
        }

        $controllerName = $this->routes[$routeKey]['controller'];
        $method = $this->routes[$routeKey]['method'];
        $this->params = array_slice($urlParts, 2);

        $controllerClass = 'App\\Controllers\\' . $controllerName;

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controller class '$controllerClass' not found.";
            exit;
        }

        // Auto-resolve controller with dependencies
        $this->controller = resolve($controllerClass);
        $this->method = $method;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::check();
        }

        // Call controller method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Automatically resolves and instantiates a class by its fully qualified name.
     *
     * Converts the namespace-based class path into a real file path, requires the file,
     * and returns a new instance of the class.
     *
     * @param string $class Fully qualified class name (e.g., App\Services\AuthService)
     * @return object Instantiated class object
     * @throws \Exception If the class file does not exist
     */
    function resolve(string $class)
    {
        // Convert namespace to path and build full file path
        $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';

        // Check if the file exists before requiring it
        if (!file_exists($path)) {
            throw new \Exception("Class file for {$class} not found at: {$path}");
        }

        // Load the class definition
        require_once $path;

        // Instantiate and return the class
        return new $class();
    }



    /**
     * Parses the URL from the request and returns parts as an array.
     *
     * @return array
     */
    private function parseUrl(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');
        return explode('/', $uri);
    }
}
