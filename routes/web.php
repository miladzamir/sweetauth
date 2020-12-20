<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers', 'middleware' => 'web'], function () {
    foreach (config('swauth.table') as $table){
        foreach (str_replace('.', '/', $table['viewRouteNames']) as $key=>$view){
            Route::get(str_replace('.', '/', $key), 'ViewHandlerController@showView')->name($key);
        }
    }
    Route::post('stepOne', 'StepOneController@configure')->name('stepOne');
    Route::post('stepTwo', 'StepTwoController@configure')->name('stepTwo');
    Route::post('stepThree', 'StepThreeController@configure')->name('stepThree');
});
