<?php

namespace App\Contracts\Dao;

interface UserDaoInterface
{
    /**
     * Get All users list
     * @return users
     */
    public function getAllUsers();
    
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

    /**
     * Update Password
     * @param passwords
     */
    public function updatePassword($passwords);
}