<?php

use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthUserController::class,'ShowLoginForm'])->name('GoLogin');
Route::get('register', [AuthUserController::class,'ShowRegisterForm'])->name('GoRegister');
Route::post('/register', [AuthUserController::class, 'PostRegisterInfo'])->name('GoRegisterPost');
Route::post('/login', [AuthUserController::class, 'PostLoginInfo'])->name('GoLoginPost');
Route::post('logout', [AuthUserController::class, 'logout'])->middleware('auth')->name('logout');


Route::middleware(['auth', RoleMiddleware::class . ':ADMIN'])->prefix('admin')->group(function () {
   
   Route::get('dashboard', function () {
        return view('base/admin/dashboard'); // create this view
    })->name('GotoDashboard');

});

Route::middleware(['auth', RoleMiddleware::class . ':USER'])->prefix('user')->group(function () {
    
    Route::get('main', function () {
        return view('base/user/main'); // create this view
    })->name('GotoMain');

});
