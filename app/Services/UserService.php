<?php

namespace App\Services;

use DateTime;
use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    // file dao for injecting PostDaoInterface
    private $userDao;

    /**
     * Class Constructor
     * @param PostDaoInterface
     * @return
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Get all User list
     * @return users
     */
    public function getUserList()
    {
        return $this->userDao->getAllUsers();
    }
    /**
     * Create new user
     * @param user
     */
    public function registerUser($user)
    {
        $user->password = Hash::make($user->password);
        $user->type = $user->type == 'Admin' ? 0 : 1;
        $user->dob = new DateTime($user->dob);
        $user->create_user_id = auth()->user()->type;
        $user->updated_user_id = auth()->user()->type;
        $this->userDao->registerUser($user);
    }

    /**
     * Update User
     * @param user
     */
    public function editProfile($user)
    {
        $user->type = $user->type == 'Admin' ? 0 : 1;
        $user->dob = Carbon::parse($user->dob);
        $user->updated_user_id = auth()->user()->type;
        $user->updated_at = now();
        $this->userDao->updateUser($user);
    }

    /**
     * Delete User
     * @param User
     */
    public function deleteUser($user)
    {
        $user->deleted_at = now();
        $user->deleted_user_id = auth()->user()->type;
        $this->userDao->softDeleteUser($user);
    }

    /**
     * Update password
     * @param passwords
     */
    public function updatePassword($passwords)
    {
        $this->userDao->updatePassword($passwords);
    }

    /**
     * Search User list
     * 
     * @param name,email,start_date,end_date
     */
    public function searchUserList($name, $email, $start_date, $end_date)
    {
        return $this->userDao->searchUserList($name, $email, $start_date, $end_date);
    }
}