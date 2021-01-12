<?php

namespace App\Contracts\Dao;

interface UserDaoInterface
{
    /**
     * Register User
     * @param user
     */
    public function registerUser($user);

    /**
     * Update User
     * @param user
     */
    public function updateUser($user);

    /**
     * Soft Delete User
     * @param user
     */
    public function softDeleteUser($user);
}