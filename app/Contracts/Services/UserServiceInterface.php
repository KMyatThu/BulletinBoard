<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    /**
     * Register User
     * @param user
     */
    public function registerUser($user);

    /**
     * Register user
     * @param user
     */
    public function editProfile($user);

    /**
     * Delete User
     * @param user
     */
    public function deleteUser($user);
}