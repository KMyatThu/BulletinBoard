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
        $this->userServiceInterface->registerUser($user);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
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
        $this->userServiceInterface->editProfile($user);
        return redirect()->route('users.index')
            ->with('success', 'User profile update successfully.');
    }

    /**
     * Delete user
     *
     * @param user
     */
    public function destroy(User $user)
    {
        $this->userServiceInterface->deleteUser($user);
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Change password
     *
     * @return void
     */
    public function passwordChange(Request $request, User $user)
    {
        return view('users.passwordChange');
    }

    /**
     * Change password
     * @param request
     * @return void
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $passwords = $request->all();
        $this->userServiceInterface->updatePassword($passwords);
        return redirect()->route('users.index')
            ->with('success', 'Password Update successfully');
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
        return view('users.profile', compact('user'));
    }
}
