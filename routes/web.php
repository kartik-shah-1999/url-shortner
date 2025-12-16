<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthenticationController::class,'signupView'])->name('signupView');
Route::post('/',[AuthenticationController::class,'signup'])->name('signup');
Route::get('/login',[AuthenticationController::class,'loginView'])->name('loginView');
Route::post('/login',[AuthenticationController::class,'login'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::prefix('dashboard')->group(function(){
        Route::get('/',[AuthenticationController::class,'dashboard'])->name('dashboard');
        Route::get('/company',[CompanyController::class,'index'])->name('company');
        Route::post('/company',[CompanyController::class,'createCompany'])->name('createCompany');
    });
    Route::post('/logout',[AuthenticationController::class,'logout'])->name('logout');
});