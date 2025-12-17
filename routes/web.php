<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UrlShortnerController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthenticationController::class,'signupView'])->name('signupView');
Route::post('/',[AuthenticationController::class,'signup'])->name('signup');
Route::get('/login',[AuthenticationController::class,'loginView'])->name('loginView');
Route::post('/login',[AuthenticationController::class,'login'])->name('login');

Route::get('/urls',[UrlShortnerController::class,'showAllUrls'])->name('showAllUrls');

Route::middleware(['auth'])->group(function(){
    Route::prefix('dashboard')->group(function(){
        Route::get('/',[AuthenticationController::class,'dashboard'])->name('dashboard');
        Route::get('/company',[CompanyController::class,'index'])->name('company')->middleware('superadminmiddleware');;
        Route::post('/company',[CompanyController::class,'createCompany'])->name('createCompany')->middleware('superadminmiddleware');
        Route::get('/role',[CompanyController::class,'roleView'])->name('roleView')->middleware('superadminmiddleware');
        Route::patch('/updateRole/{id}',[CompanyController::class,'updateRole'])->name('updateRole')->middleware('superadminmiddleware');
        Route::get('/invite',[CompanyController::class,'inviteView'])->name('inviteView')->middleware('invitemiddleware');
        Route::post('/invite/{id}',[CompanyController::class,'inviteUser'])->name('inviteUser');
        Route::get('/shortenedUrls',[UrlShortnerController::class,'shortenedUrls'])->name('shortenedUrls');
        Route::get('/urlShortner',[UrlShortnerController::class,'index'])->name('urlShortnerView');
        Route::post('/urlShortner',[UrlShortnerController::class,'urlShortner'])->name('urlShortner');
    });
    Route::post('/logout',[AuthenticationController::class,'logout'])->name('logout');
});

Route::get('/{hash}',[UrlShortnerController::class,'redirectUrl'])
       ->name('redirectUrl')
       ->where('hash', '^(?!login|register|dashboard).+$');