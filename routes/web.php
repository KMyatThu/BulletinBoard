<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('users', UserController::class);
Route::post('/userCreateConfirm', UserController::class .'@userCreateConfirm');
Route::post('/createUser', UserController::class .'@createUser');
Route::post('/editProfile', UserController::class .'@editProfile');
Route::get('/userDeleteModal/{user}', UserController::class .'@userDeleteModal');
Route::get('/destroy/{user}', UserController::class .'@destroy');
Route::get('users/{user}/passwordChange', UserController::class .'@passwordChange');
Route::post('users/{user}/updatePassword', UserController::class .'@updatePassword');
Route::get('profile/{user}', UserController::class .'@profile');

Route::resource('posts', PostController::class);
Route::get('postList', PostController::class .'@postList');
Route::get('posts/{post}/destroy', PostController::class .'@destroy');
Route::post('posts/postCreateConfirm', PostController::class .'@postCreateConfirm');
Route::post('/postUpdateConfirm', PostController::class .'@postUpdateConfirm');
Route::post('/update', PostController::class .'@update');
Route::post('posts/search', PostController::class .'@search');
Route::get('postUploadIndex', PostController::class .'@postUploadIndex');
Route::post('upload', PostController::class .'@upload');
Route::get('download', PostController::class .'@download');
Route::get('/postReturn/{{post}}', PostController::class .'@postReturn');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
