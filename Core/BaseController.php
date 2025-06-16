<?php

namespace App\Core;

use App\Services\LogService;

/**
 * Class BaseController
 *
 * Provides common controller functionality such as rendering views,
 * handling exceptions, authorization checks, and JSON responses.
 */
class BaseController
{
    /**
     * Injected logging service used for error tracking.
     */
    public function __construct(
        private LogService $logService
    ) {}

    /**
     * Redirects the user to a given URL and stops script execution.
     *
     * @param string $url
     * @return void
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    /**
     * Ensures the user is authenticated. Redirects to login if not.
     *
     * @param string $redirectUrl
     * @return void
     */
    protected function requireAuthRedirect(string $redirectUrl = '/login')
    {
        if (!isset($_SESSION['user']['id'])) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    /**
     * Sends a JSON response with a specific HTTP status code and exits.
     *
     * @param array $data
     * @param int $status
     * @return void
     */
    protected function jsonResponse(array $data = [], int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Renders a view with optional parameters inside the main layout.
     *
     * @param string $view
     * @param array $params
     * @return void
     */
    protected function renderView(string $view, array $params = [])
    {
        extract($params);
        $viewPath = __DIR__ . '/../views/' . $view;
        include __DIR__ . '/../views/layout.php';
    }

    /**
     * Verifies that the user has a given role.
     * Returns 401 or 403 response if access is denied.
     *
     * @param string|null $role
     * @return void
     */
    protected function checkAccess(string $role = null)
    {
        if (!isset($_SESSION['user'])) {
            $this->jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $roles = json_decode($_SESSION['user']['roles'], true);
        if ($role && !in_array($role, $roles)) {
            $this->jsonResponse(['error' => 'Forbidden'], 403);
        }
    }

    /**
     * Handles exceptions by logging and returning a generic error response.
     *
     * @param \Throwable $e
     * @return void
     */
    protected function handleException(\Throwable $e)
    {
        $this->logService->write($e->getMessage(), 'ERROR');
        $this->jsonResponse(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Dynamically loads a model class by name.
     * Logs and throws an error if the file or class is missing.
     *
     * @param string $modelName
     * @return object
     * @throws \Exception
     */
    protected function loadModel(string $modelName)
    {
        $modelPath = __DIR__ . '/../Models/' . $modelName . '.php';

        if (!file_exists($modelPath)) {
            $this->logService->write("Model file not found: $modelPath", 'ERROR');
            throw new \Exception("Model not found: $modelName");
        }

        require_once $modelPath;

        $fullyQualifiedClass = "App\\models\\$modelName";

        if (!class_exists($fullyQualifiedClass)) {
            $this->logService->write("Model class not found: $fullyQualifiedClass", 'ERROR');
            throw new \Exception("Model class $fullyQualifiedClass does not exist.");
        }

        return new $fullyQualifiedClass;
    }

    /**
     * Alias for jsonResponse() with a stricter type hint.
     *
     * @param array $data
     * @param int $status
     * @return void
     */
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
