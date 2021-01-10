<?php

namespace App\Http\Controllers;

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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $name = (!empty($_GET["name"])) ? ($_GET["name"]) : ('');
        $email = (!empty($_GET["email"])) ? ($_GET["email"]) : ('');
        $from = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
        $to = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');
        $users = User::whereNull('deleted_user_id');
        if($name != '') $users->where('name', 'LIKE', '%' . $name . '%');
        if($email != '') $users ->where('email', 'LIKE', '%' . $email . '%');
        if($from != '') $users ->where('created_at','>=',$from.' 00:00:00');
        if($to != '') $users->where('created_at','<=',$to.' 23:59:59');
        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return '<a data-toggle="modal" id="mediumButton" data-target="#mediumModal" class="btn btn-link" data-attr="/users/'. $row->id .'">'. $row->name .'</a>';
                })
                ->addColumn('action', function ($row) {
                    return '<a data-toggle="modal" id="deleteButton" data-target="#deleteModal" data-attr="/userDeleteModal/'. $row->id .'" class="btn btn-danger">Delete</a>';
                })
                ->editColumn('dob', function ($row) 
                {
                return $row->dob == null ? '' : date('Y/m/d', strtotime($row->dob));
                })
                ->editColumn('type', function ($row) 
                {
                return $row->type == 0 ? 'Admin' : 'User';
                })
                ->editColumn('created_at', function ($row) 
                {
                return date('Y/m/d', strtotime($row->created_at) );
                })
                ->editColumn('updated_at', function ($row) 
                {
                return date('Y/m/d', strtotime($row->updated_at) );
                })
                ->rawColumns(['name'],['action'])
                ->make(true);
        }
        return view('users.usersList');
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
            Image::make($image)->resize(300, 300)->save(public_path('/uploads/images/' . $filename ));
            $user->profile = $filename;
        }

        return view('users.userCreateConfirm', compact('user'));
    }

    public function createUser(UserFormRequest $request, User $user)
    {
        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        $user->type = $user->type == 'Admin' ? 0 : 1;
        $user->dob = new DateTime($user->dob);
        $user->create_user_id = auth()->user()->type;
        $user->updated_user_id = auth()->user()->type;
        $user->created_at = new DateTime();
        $user->updated_at = new DateTime();
        DB::table('users')->insert([
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
            Image::make($image)->resize(300, 300)->save( public_path('/uploads/images/' . $filename ));
            $user->profile = $filename;
        }

        $user->type = $user->type == 'Admin' ? 0 : 1;
        $user->dob = Carbon::parse($user->dob);
        $user->updated_user_id = auth()->user()->type;
        $user->updated_at = new DateTime();
        DB::table('users')->where('id', $user->id)->update([
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['type'],
            'phone' => $user['phone'],
            'address' => $user['address'],
            'dob' => $user['dob'],
            'profile' => $user['profile'],
            'updated_user_id' => $user['updated_user_id'],
            'updated_at' => $user['updated_at']
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User profile update successfully.');
    }

    public function destroy(User $user)
    {
        $user->deleted_at = new DateTime();
        DB::table('users')->where('id', $user->id)->update([
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

        DB::table('users')->where('id', auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);
        
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
