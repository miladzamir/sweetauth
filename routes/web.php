<?php

use Illuminate\Support\Facades\Route;
use MiladZamir\SweetAuth\Http\Controllers;

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers'], function (){
    Route::post('/ReceiveRequest', 'ReceiveRequestController@ReceiveRequest')->name('receive.request');

});
