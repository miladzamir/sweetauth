<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers' , 'middleware' => 'web'], function () {

    Route::post('/ReceiveRequest', 'ReceiveRequestController@ReceiveRequest')->name('receive.request');

    Route::post('/VerifyRequest', 'VerifyRequestController@VerifyRequest')->name('verify.request');

    Route::post('/CreateUser', 'CreateUserController@CreateUser')->name('create.user');

});
