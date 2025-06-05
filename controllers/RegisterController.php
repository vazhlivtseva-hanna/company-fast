<?php

namespace App\controllers;

use App\Core\Controller;
use App\Core\Validator;

/**
 * Class RegisterController
 *
 * Handles user registration and input validation.
 */
class RegisterController extends Controller
{
    /** @const int Minimum length for first name and last name */
    const MIN_LENGTH = 4;

    /** @const int Maximum allowed length for the first name */
    const MAX_FIRST_NAME_LENGTH = 15;

    /** @const int Maximum allowed password length */
    const MAX_PASSWORD_LENGTH = 16;

    /** @const int Minimum required password length */
    const MIN_PASSWORD_LENGTH = 6;

    /** @const int Maximum allowed length for the last name */
    const MAX_LAST_NAME_LENGTH = 25;

    /**
     * Displays the user registration form.
     *
     * This method is triggered by a GET request to the /register route.
     * It logs the page view and renders the registration view containing the HTML form.
     *
     * @return void
     */
    public function showForm(): void
    {
        $logger = $this->loadModel('ActivityLog');
        $logger->log('view_page', 'register');

        $this->renderView('register');
    }

    /**
     * Handles the form submission for user registration.
     *
     * This method validates the incoming POST data, checks if the email already exists,
     * and creates a new user if all validations pass.
     * Upon successful registration, redirects the user to the login page.
     * If validation fails, re-renders the registration form with errors.
     *
     * @return void
     */
    public function submitForm(): void
    {
        $userModel = $this->loadModel("User");

        // Validate form input
        $validator = new Validator($_POST);
        $validator->required(['first_name', 'last_name', 'email', 'password']);
        $validator->minLength('first_name', self::MIN_LENGTH);
        $validator->maxLength('first_name', self::MAX_FIRST_NAME_LENGTH);
        $validator->minLength('last_name', self::MIN_LENGTH);
        $validator->maxLength('last_name', self::MAX_LAST_NAME_LENGTH);
        $validator->email('email');
        $validator->minLength('password', self::MIN_PASSWORD_LENGTH);
        $validator->maxLength('password', self::MAX_PASSWORD_LENGTH);
        $validator->strongPassword('password');

        $errors = $validator->errors();

        // Check if the email is already registered
        if ($userModel->findByEmail($_POST['email'])) {
            $errors['email'] = 'Email is already taken';
        }

        // If no validation errors, create the user
        if (empty($errors)) {
            $userModel->create($_POST);
            header("Location: /?url=login");
            exit;
        } else {
            // Otherwise, return to the form with validation errors
            $this->renderView('register', ['errors' => $errors]);
        }
    }
}
