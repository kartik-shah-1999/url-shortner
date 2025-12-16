<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthenticationController::class,'signupView'])->name('signupView');
Route::post('/',[AuthenticationController::class,'signup'])->name('signup');
Route::get('/login',[AuthenticationController::class,'loginView'])->name('loginView');
Route::post('/login',[AuthenticationController::class,'login'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[AuthenticationController::class,'dashboard'])->name('dashboard');
    Route::post('/logout',[AuthenticationController::class,'logout'])->name('logout');
});