<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::POSTS;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $message = array(
            'phone.regex' => 'Phone no starting with 0 and following 10 digits'
        );
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^.+@.+$/i'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'type' => ['required', 'numeric', 'regex:/^[0-1]$/i'],
            'phone' => ['required', 'numeric', 'regex:/(0)[0-9]{10}$/'],
            'dob' => ['required', 'string', 'date_format:m/d/Y'],
            'address' => ['required', 'string'],
            'file' => ['required', 'image', 'mimes:jpg,bmp,png,jpeg']
        ], $message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(User $data)
    {
        $result = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'address' => $data['address'],
            'profile' => $data['profile'],
            'create_user_id' => $data['create_user_id'],
            'updated_user_id' => $data['updated_user_id']
        ])->id;
        $data->id = $result;
        return $data;
    }
}
