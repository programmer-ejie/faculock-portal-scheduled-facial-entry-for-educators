<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrefController;

Route::get('/', function () {
    return view('index');
});

Route::get('landing_page',[HrefController::class, 'gotoIndex'])->name('index');
Route::get('login',[HrefController::class , 'gotoLogin'])->name('login');
Route::get('register',[HrefController::class,'gotoRegister'])->name('register');