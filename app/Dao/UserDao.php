<?php

namespace App\Dao;

use App\Contracts\Dao\UserDaoInterface;
use App\User;

class UserDao implements UserDaoInterface
{
    /**
     * Register User
     * @param user
     */
    public function registerUser($user)
    {
        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
            'profile' => $user['profile'],
            'type' => $user['type'],
            'phone' => $user['phone'],
            'address' => $user['address'],
            'dob' => $user['dob'],
            'create_user_id' => $user['create_user_id'],
            'updated_user_id' => $user['updated_user_id'],
        ]);
    }

    /**
     * Update User
     * @param user
     */
    public function updateUser($user)
    {
        User::where('id', $user->id)->update([
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['type'],
            'phone' => $user['phone'],
            'address' => $user['address'],
            'dob' => $user['dob'],
            'profile' => $user['profile'],
        ]);
    }

    /**
     * Delete User
     * @param user
     */
    public function softDeleteUser($user)
    {
        User::where('id', $user->id)->update([
            'deleted_user_id' => $user['deleted_user_id'],
            'deleted_at' => $user['deleted_at'],
        ]);
    }
}