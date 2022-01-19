<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('login', function () {
    if(Auth::check()){
        return view('elements.home');
    } else {
        return view("login");
    }
});
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'management', "middleware" => "checklogin"], function () {
    Route::get('home', [EmployeeController::class, 'home'])->name('home');

    Route::group(['prefix' => 'team'], function () {
        Route::get('search', [TeamController::class, 'show'])->name('team.search');
        Route::get('create', [TeamController::class, 'create'])->name('team.create');
        Route::post('create', [TeamController::class, 'store'])->name('team.store');
        Route::post('create_confirm', [TeamController::class, 'createConfirm'])->name('team.create_confirm');
        Route::get('edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
        Route::post('edit_confirm/{id}', [TeamController::class, 'editConfirm'])->name('team.edit_confirm');
        Route::post('edit/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::get('delete/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
        Route::get('back', [TeamController::class, 'returnBack'])->name('team.return_back');
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::get('search', [EmployeeController::class, 'show'])->name('employee.search');
        Route::get('create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('create', [EmployeeController::class, 'store'])->name('employee.store');
        Route::post('create_confirm', [EmployeeController::class, 'createConfirm'])->name('employee.create_confirm');
        Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('edit_confirm/{id}', [EmployeeController::class, 'editConfirm'])->name('employee.edit_confirm');
        Route::post('edit/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('back', [EmployeeController::class, 'returnBack'])->name('employee.back');
        Route::get('export', [EmployeeController::class, 'export'])->name('employee.export');
    });
});
