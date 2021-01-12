<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\UserFormRequest;
use App\Rules\MatchOldPassword;
use App\User;
use DateTime;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

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

    public function index(Request $request)
    {
        $name = (!empty($_GET["name"])) ? ($_GET["name"]) : ('');
        $email = (!empty($_GET["email"])) ? ($_GET["email"]) : ('');
        $from = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
        $to = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');
        $users = User::whereNull('deleted_user_id');
        if ($name != '') $users->where('name', 'LIKE', '%' . $name . '%');
        if ($email != '') $users->where('email', 'LIKE', '%' . $email . '%');
        if ($from != '') $users->where('created_at', '>=', $from . ' 00:00:00');
        if ($to != '') $users->where('created_at', '<=', $to . ' 23:59:59');
        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return '<a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/users/' . $row->id . '">' . $row->name . '</a>';
                })
                ->addColumn('action', function ($row) {
                    return '<a data-toggle="modal" id="deleteButton" data-target="#deleteModal" data-attr="/userDeleteModal/' . $row->id . '" class="btn btn-danger">Delete</a>';
                })
                ->editColumn('dob', function ($row) {
                    return $row->dob == null ? '' : date('Y/m/d', strtotime($row->dob));
                })
                ->editColumn('type', function ($row) {
                    return $row->type == 0 ? 'Admin' : 'User';
                })
                ->editColumn('created_at', function ($row) {
                    return date('Y/m/d', strtotime($row->created_at));
                })
                ->editColumn('updated_at', function ($row) {
                    return date('Y/m/d', strtotime($row->updated_at));
                })
                ->rawColumns(['name'], ['action'])
                ->make(true);
        }
        return view('users.usersList');
    }

    // public function index()
    // {
    //     return response()->json(['users' => User::whereNull('deleted_user_id')->get()]);
    //     // return view('users.usersList')->with(["users" => response()->json([$users])]);
    // }

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
    public function updatePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'newConfirmPassword' => ['same:newPassword'],
        ]);

        DB::table('users')->where('id', auth()->user()->id)->update(['password' => Hash::make($request->newPassword)]);

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
