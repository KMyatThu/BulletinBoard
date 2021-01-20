<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    /**
     * Get User List
     */
    public function getUserList();
    
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

    /**
     * Update Password
     * @param user
     */
    public function updatePassword($passwords);

    /**
     * User Search
     * 
     * @param name,email,start_date,end_date
     * 
     */
    public function searchUserList($name,$email,$start_date,$end_date);
}