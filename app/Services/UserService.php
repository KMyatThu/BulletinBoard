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
    private $userDaoInterface;

    /**
     * Class Constructor
     * @param PostDaoInterface
     * @return
     */
    public function __construct(UserDaoInterface $userDaoInterface)
    {
        $this->userDaoInterface = $userDaoInterface;
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
        $this->userDaoInterface->registerUser($user);
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
        $user->updated_at = new DateTime();
        $this->userDaoInterface->updateUser($user);
    }

    /**
     * Delete User
     * @param User
     */
    public function deleteUser($user)
    {
        $user->deleted_at = new DateTime();
        $user->deleted_user_id = auth()->user()->type;
        $this->userDaoInterface->softDeleteUser($user);
    }
}