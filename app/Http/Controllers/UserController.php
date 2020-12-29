<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use App\User;
use DateTime;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // $users = User::whereNull('deleted_user_id');
        // $users = User::all();
        // $user = User::query();
        // $users = $user->where('id','1');
        // return view('users.usersList',compact('users'));
        // return view('users.usersList')->with([
        //     'users' => $users,
        //     ]);
        $users = User::whereNull('deleted_user_id')->paginate(5);
        return view('users.usersList', compact('users'));
    }

    public function create()
    {
        return view('users.userCreate');
    }

    public function userCreateConfirm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $user = new User($request->all());
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $filename = $user->name . "_" . time() . '.' . $image->getClientOriginalExtension();
            // $image->move(public_path('/uploads/images/'), $filename);
            Image::make($image)->resize(300, 300)->save(public_path('/uploads/images/' . $filename ));
            $user->profile = $filename;
        }

        return view('users.userCreateConfirm', compact('user'));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        $user->type = $user->type == 'Admin' ? 1 : 0;
        $user->create_user_id = 1;
        $user->updated_user_id = 1;
        $user->created_at = new DateTime();
        $user->updated_at = new DateTime();

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
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at']
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        dd("here");
        return view('users.userDetail', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.userEdit', compact('user'));
    }

    public function editProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user = new User($request->all());
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $filename = $user->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save( public_path('/uploads/images/' . $filename ));
            $user->profile = $filename;
        }

        $user->type = $user->type == 'Admin' ? 1 : 0;
        $user->create_user_id = 1;
        $user->updated_user_id = 1;
        $user->updated_at = new DateTime();

        User::where('id', $user->id)->update([
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['type'],
            'phone' => $user['phone'],
            'address' => $user['address'],
            'dob' => $user['dob'],
            'profile' => $user['profile'],
            'create_user_id' => $user['create_user_id'],
            'updated_user_id' => $user['updated_user_id'],
            'updated_at' => $user['updated_at']
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User profile update successfully.');
    }

    public function destroy(User $user)
    {
        dd("destroy");
        $user->deleted_at = new DateTime();
        User::where('id', $user->id)->update([
            'deleted_user_id' => '1',
            'deleted_at' => $user['deleted_at']
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function passwordChange(Request $request, User $user)
    {
        return view('users.passwordChange');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'newConfirmPassword' => ['same:newPassword'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);
        
        return redirect()->route('users.index')
            ->with('success', 'Password Update successfully');
    }

    public function userDeleteModal(User $user)
    {
        return view('users.userDeleteModal', compact('user'));
    }
}
