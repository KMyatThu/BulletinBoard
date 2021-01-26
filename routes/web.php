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
Route::prefix('users')->group(function () {
    Route::post('/userCreateConfirm', UserController::class .'@userCreateConfirm');
    Route::post('/createUser', UserController::class .'@createUser');
    Route::get('/{user}/profile', UserController::class .'@profile');
    Route::post('/{user}/editProfile', UserController::class .'@editProfile');
    Route::get('/{user}/userDeleteModal', UserController::class .'@userDeleteModal');
    Route::get('/{user}/destroy', UserController::class .'@destroy');
    Route::post('searchUser', UserController::class .'@searchUser');
    Route::get('/{user}/passwordChange', UserController::class .'@passwordChange');
    Route::post('/{user}/updatePassword', UserController::class .'@updatePassword');
});

Route::resource('posts', PostController::class);
Route::prefix('posts')->group(function () {
    Route::get('/{post}/destroy', PostController::class .'@destroy');
    Route::post('/postCreateConfirm', PostController::class .'@postCreateConfirm');
    Route::post('/{post}/postUpdateConfirm', PostController::class .'@postUpdateConfirm');
    Route::post('/{post}/update', PostController::class .'@update');
    Route::any('/post/searchPost', PostController::class .'@searchPost');
    Route::get('/post/download', PostController::class .'@download');
    Route::get('/post/uploadIndex', PostController::class .'@uploadIndex');
    Route::post('/post/upload', PostController::class .'@upload');
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

