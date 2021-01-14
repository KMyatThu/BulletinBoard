<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\ChangePasswordRequest;
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

    public function index()
    {
        $users = $this->userServiceInterface->getUserList();
        return view('users.usersList')->with(["users" => $users]);
    }

    public function create()
    {
        return view('users.userCreate');
    }

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

    public function createUser(UserFormRequest $request, User $user)
    {
        $user = new User($request->all());
        $this->userServiceInterface->registerUser($user);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.userDetail', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.userEdit', compact('user'));
    }

    public function editProfile(UserFormRequest $request, User $user)
    {
        $user = new User($request->all());
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $filename = $user->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('/uploads/images/' . $filename));
            $user->profile = $filename;
        }
        $this->userServiceInterface->editProfile($user);
        return redirect()->route('users.index')
            ->with('success', 'User profile update successfully.');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function destroy(User $user)
    {
        $this->userServiceInterface->deleteUser($user);
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

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

    public function userDeleteModal(User $user)
    {
        return view('users.userDeleteModal', compact('user'));
    }

    public function profile(User $user)
    {
        return view('users.profile', compact('user'));
    }
}
