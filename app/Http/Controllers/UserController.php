<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserEditFormRequest;
use App\Http\Requests\UserFormRequest;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userServiceInterface;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->middleware('auth');
        $this->userServiceInterface = $userServiceInterface;
    }

    /**
     * User Lists
     *
     * @return users
     */
    public function index()
    {
        $users = $this->userServiceInterface->getUserList();
        return view('users.usersList')->with(["users" => $users]);
    }

    /**
     * Create a new user form
     *
     * @return void
     */
    public function create()
    {
        return view('users.userCreate');
    }

    /**
     * Create and confirm to the user
     *
     * @return user
     */
    public function userCreateConfirm(UserFormRequest $request)
    {
        $user = new User($request->all());
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $filename = $user->name . "_" . time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('/uploads/images/' . $filename));
            $user->profile = $filename;
        }

        return view('users.userCreateConfirm', compact('user'));
    }

    /**
     * Create a user to the database.
     *
     * @return void
     */
    public function createUser(Request $request, User $user)
    {
        $user = new User($request->all());
        $userCreated = $this->userServiceInterface->registerUser($user);
        if ($userCreated) {
            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } else {
            return redirect()->route('users.index')
                ->with('error', 'User not created.');
        }
    }

    /**
     * User detail
     *
     * @param user
     * @return user
     */
    public function show(User $user)
    {
        return view('users.userDetail', compact('user'));
    }

    /**
     * Edit user
     *
     * @param user
     */
    public function edit(User $user)
    {
        return view('users.userEdit', compact('user'));
    }

    /**
     * Edit user profile
     *
     * @param request,user
     */
    public function editProfile(UserEditFormRequest $request, User $user)
    {
        $user = new User($request->all());
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $filename = $user->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('/uploads/images/' . $filename));
            $user->profile = $filename;
        }
        $userEdited = $this->userServiceInterface->editProfile($user);
        if ($userEdited == 1) {
            return redirect()->route('users.index')
                ->with('success', 'User profile update successfully.');
        } else {
            return redirect()->route('users.index')
                ->with('error', 'User profile not updated.');
        }
    }

    /**
     * Delete user
     *
     * @param user
     */
    public function destroy(User $user)
    {
        $userDeleted = $this->userServiceInterface->deleteUser($user);
        if ($userDeleted == 1) {
            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('users.index')
                ->with('error', 'User not deleted');
        }
    }

    /**
     * Change password
     *
     * @return void
     */
    public function passwordChange()
    {
        return view('users.userChangePassword');
    }

    /**
     * Change password
     * @param request
     * @return void
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $passwords = $request->all();
        $userUpdatedPassword = $this->userServiceInterface->updatePassword($passwords);
        if($userUpdatedPassword == 1){
            return redirect()->route('users.index')
                ->with('success', 'Password Update successfully');
        } else {
            return redirect()->route('users.index')
                ->with('error', 'Password not updated');
        }
    }

    /**
     * User detail to display in Delete modal
     *
     * @param user
     */
    public function userDeleteModal(User $user)
    {
        return view('users.userDeleteModal', compact('user'));
    }

    /**
     * Display User Profile
     *
     * @param user
     */
    public function profile(User $user)
    {
        return view('users.userProfile', compact('user'));
    }

    /**
     * Search users
     * 
     * @param request
     */
    public function searchUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        if($end_date != null && $end_date != "" && $start_date > $end_date){
            return redirect()->route('users.index')->with('error', 'Start date is greater than End date');
        }
        $users = $this->userServiceInterface->searchUserList($name, $email, $start_date, $end_date);
        return view('users.usersList')->with(["users" => $users]);
    }
}
