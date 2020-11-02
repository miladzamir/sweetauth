<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers'], function () {

    Route::post('/ReceiveRequest', 'ReceiveRequestController@ReceiveRequest')->name('receive.request');

});
