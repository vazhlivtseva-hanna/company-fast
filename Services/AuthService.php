<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    /**
     * Attempt to authenticate user by email and password
     *
     * @param string $email
     * @param string $password
     * @return array|null Authenticated user or null
     */
    public function authenticate(string $email, string $password): ?array
    {
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Check credentials
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Remember email in a cookie for 30 days
     *
     * @param string $email
     * @return void
     */
    public function rememberEmail(string $email): void
    {
        setcookie('remember_email', $email, time() + (86400 * 30), "/");
    }
}
