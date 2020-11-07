<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers\Auth', 'middleware' => 'web'], function () {
    Auth::routes([
        'login' => false,
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]);
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers', 'middleware' => 'web'], function () {
    Route::post('/ReceiveRequest', 'ReceiveRequestController@ReceiveRequest')->name('receive.request');
    Route::post('/VerifyRequest', 'VerifyRequestController@VerifyRequest')->name('verify.request');
    Route::post('/CreateUser', 'CreateUserController@CreateUser')->name('create.user');
    Route::post('/forgotPassword', 'ForgetPasswordController@forgotPassword')->name('forgot.password.request');
    Route::post('/UpdateUserPassword', 'UpdateUserPasswordController@UserPassword')->name('user.password');


    Route::get('/auth', 'ViewPageController@myView')->middleware('is.register.step')->name('auth');
    Route::get('/verify', 'ViewPageController@verify')->middleware('is.receive.and.stored')->name('verify');
    Route::get('/register', 'ViewPageController@register')->middleware('is.verify')->name('register');
    Route::get('/login', 'ViewPageController@login')->name('login');
    Route::get('/forgotPassword', 'ViewPageController@forgotPassword')->name('forgot.password');
    Route::get('/resetPassword', 'ViewPageController@resetPassword')->middleware('is.verify')->name('reset.password');

});

