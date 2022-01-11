<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view("login");
});
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'management', "middleware" => "checklogin"], function () {
    Route::get('home', [EmployeeController::class, 'home'])->name('home');

    Route::group(['prefix' => 'team'], function () {
        Route::get('search', [TeamController::class, 'index'])->name('team.search');
        Route::post('create_confirm', [TeamController::class, 'createConfirm'])->name('team.create_confirm');
        Route::post('edit_confirm/{id}', [TeamController::class, 'editConfirm'])->name('team.edit_confirm');
    });
    Route::resource('team', TeamController::class);
});
