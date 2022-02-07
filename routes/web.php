<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TeamController;
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
//
Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'checkLogin'])->name('login');
Route::get('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'management', "middleware" => ["checklogin", "checkAccount"]], function () {
    Route::get('home', [EmployeeController::class, 'home'])->name('home');

    Route::group(['prefix' => 'team'], function () {
        Route::get('search', [TeamController::class, 'show'])->name('team.search');
        Route::post('create_confirm', [TeamController::class, 'createConfirm'])->name('team.create_confirm');
        Route::post('edit_confirm/{id}', [TeamController::class, 'editConfirm'])->name('team.edit_confirm');
        Route::get('delete/{team}', [TeamController::class, 'destroy'])->name('team.destroy');
        Route::get('back', [TeamController::class, 'returnBack'])->name('team.return_back');
    });
    Route::resource('team', TeamController::class)->only('create', 'store', 'edit', 'update');

    Route::group(['prefix' => 'employee'], function () {
        Route::get('search', [EmployeeController::class, 'show'])->name('employee.search');
        Route::post('create_confirm', [EmployeeController::class, 'createConfirm'])->name('employee.create_confirm');
        Route::post('edit_confirm/{id}', [EmployeeController::class, 'editConfirm'])->name('employee.edit_confirm');
        Route::get('delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('export', [EmployeeController::class, 'export'])->name('employee.export');
    });
    Route::resource('employee', EmployeeController::class)->only('create', 'store', 'edit', 'update');
});
