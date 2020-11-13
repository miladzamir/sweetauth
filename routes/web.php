<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers\Handler', 'middleware' => 'web'], function () {
    Route::get(config('swauth.viewRouteNames.step1.0'), 'ViewHandlerController@stepOneMethodZero')->name(config('swauth.viewRouteNames.step1.0'));
    Route::get(config('swauth.viewRouteNames.step1.1'), 'ViewHandlerController@stepOneMethodOne')->name(config('swauth.viewRouteNames.step1.1'));
    Route::get(config('swauth.viewRouteNames.step2.0'), 'ViewHandlerController@stepTwoMethodZero')->name(config('swauth.viewRouteNames.step2.0'))->middleware('is.step.two.method.zero');
    Route::get(config('swauth.viewRouteNames.step2.1'), 'ViewHandlerController@stepTwoMethodOne')->name(config('swauth.viewRouteNames.step2.1'))->middleware('is.step.two.method.one');
    Route::get(config('swauth.viewRouteNames.step3.0'), 'ViewHandlerController@stepThreeMethodZero')->name(config('swauth.viewRouteNames.step3.0'));
    Route::get(config('swauth.viewRouteNames.step3.1'), 'ViewHandlerController@stepThreeMethodOne')->name(config('swauth.viewRouteNames.step3.1'));
    Route::get(config('swauth.viewRouteNames.step4.0'), 'ViewHandlerController@stepFourMethodZero')->name(config('swauth.viewRouteNames.step4.0'));
});

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers', 'middleware' => 'web'], function () {
    Route::post(config('swauth.postRouteNames.step1.0'), 'StepOneController@configure')->name(config('swauth.postRouteNames.step1.0'));
    Route::post(config('swauth.postRouteNames.step2.0'), 'StepTwoController@configure')->name(config('swauth.postRouteNames.step2.0'))->middleware('is.step.two.method.post');
    Route::post(config('swauth.postRouteNames.step3.0'), 'StepThreeController@configure')->name(config('swauth.postRouteNames.step3.0'));
});

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'middleware' => 'web'], function () {
    Route::post(config('swauth.postRouteNames.step4.0'), 'LoginController@login')->name(config('swauth.viewRouteNames.step4.0'));
    Route::post(config('swauth.postRouteNames.step5.0'), 'LoginController@logout')->name(config('swauth.viewRouteNames.step5.0'));
});
