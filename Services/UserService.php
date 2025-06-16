<?php

namespace App\Services;

use App\Models\User;

/**
 * Service class for handling user-related operations.
 */
class UserService
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Find a user by email address.
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        return $this->user->findByEmail($email);
    }

    /**
     * Create a new user record.
     *
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $this->user->create($data);
    }
}
