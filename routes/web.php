<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers' , 'middleware' => 'web'], function () {

    Route::post('/ReceiveRequest', 'ReceiveRequestController@ReceiveRequest')->name('receive.request');

    Route::post('/VerifyRequest', 'VerifyRequestController@VerifyRequest')->name('verify.request');

    Route::post('/CreateUser', 'CreateUserController@CreateUser')->name('create.user');


    Auth::routes();
    Route::get('/auth', 'ViewPageController@myView')->middleware('is.register.step')->name('auth');
    Route::get('/verify', 'ViewPageController@verify')->middleware('is.receive.and.stored')->name('verify');
    Route::get('/register', 'ViewPageController@register')->middleware('is.verify')->name('register');
    Route::get('/login', 'ViewPageController@login')->name('login');
    Route::get('/home', 'ViewPageController@index')->name('home');
});
