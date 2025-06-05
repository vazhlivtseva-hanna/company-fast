<?php

namespace App\controllers;

use App\Core\Controller;

/**
 * Class AuthController
 *
 * Handles user authentication: login, logout, and session management.
 */
class AuthController extends Controller
{
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
        // CSRF token validation
        if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->renderView("login", ['error' => 'Invalid CSRF token.']);
            return;
        }

        // Sanitize and validate inputs
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->renderView("login", ['error' => 'Email and password are required.']);
            return;
        }

        // Attempt to find the user and verify credentials
        $userModel = $this->loadModel("User");
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;

            // Handle "remember me" functionality
            if (!empty($_POST['remember'])) {
                setcookie('remember_email', $email, time() + (86400 * 30), "/"); // 30 days
            }

            header("Location: /dashboard");
            exit;
        } else {
            $this->renderView("login", ['error' => 'Invalid credentials.']);
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
        $logger = $this->loadModel('ActivityLog');
        $logger->log('view_page', 'login');

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
        $logger = $this->loadModel('ActivityLog');
        $logger->log('view_page', 'logout');

        session_destroy();
        header('Location: ?route=login');
    }
}
