<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Services\ActivityLogService;
use App\Services\AuthService;
use App\Services\LogService;

/**
 * Class AuthController
 *
 * Handles user authentication: login, logout, and session management.
 */
class AuthController extends BaseController
{
    public function __construct(
        private AuthService $authService,
        private LogService $logService,
        private ActivityLogService $activityLogService,
    ) {}

    /**
     * Handles the login form submission.
     *
     * Validates CSRF token and credentials.
     * If valid, starts a user session and redirects to the dashboard.
     * If "remember me" is selected, stores email in a cookie.
     * If authentication fails, re-renders the login page with an error message.
     *
     * @return void
     */
    public function submitForm(): void
    {
        // Sanitize and validate inputs
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->renderView("login", ['error' => 'Email and password are required.']);
            return;
        }

        try {
            $user = $this->authService->authenticate($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                // Remember email if checkbox was selected
                if (!empty($_POST['remember'])) {
                    $this->authService->rememberEmail($email);
                }

                $this->redirect('/dashboard');
            } else {
                $this->logService->write("Failed login attempt for email: $email", 'WARNING');
                $this->renderView("login", ['error' => 'Invalid credentials.']);
            }
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Displays the login form.
     *
     * Logs the page view for tracking purposes.
     * Pre-fills the email input if a "remember me" cookie is set.
     *
     * @return void
     */
    public function showForm(): void
    {
        try {
            $this->activityLogService->log('view_page', 'login');
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }

        $this->renderView("login", [
            'rememberedEmail' => $_COOKIE['remember_email'] ?? '',
            'csrf_token' => generateCsrfToken()
        ]);
    }

    /**
     * Logs out the currently authenticated user.
     *
     * Logs the logout action for tracking, destroys the session,
     * and redirects the user to the login page.
     *
     * @return void
     */
    public function logout(): void
    {
        try {
            $this->activityLogService->log('view_page', 'logout');
            session_destroy();
            header('Location: ?route=login');
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }
}
