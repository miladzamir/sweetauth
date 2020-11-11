<?php

use Illuminate\Support\Facades\Route;

/*
Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers', 'middleware' => 'web'], function () {
    Route::post('/ReceiveRequest', 'ReceiveRequestController@ReceiveRequest')->name('receive.request');
    Route::post('/VerifyRequest', 'VerifyRequestController@VerifyRequest')->name('verify.request');
    Route::post('/CreateUser', 'CreateUserController@CreateUser')->name('create.user');
    Route::post('/UpdateUserPassword', 'UpdateUserPasswordController@UserPassword')->name('user.password');

       Route::get('/auth', 'ViewPageController@myView')->middleware('is.register.step')->name('auth');
        Route::get('/verify', 'ViewPageController@verify')->middleware('is.receive.and.stored')->name('verify');
        Route::get('/register', 'ViewPageController@register')->middleware('is.verify')->name('register');
        Route::get('/login', 'ViewPageController@login')->name('login');
        Route::get('/forgotPassword', 'ViewPageController@forgotPassword')->name('forgot.password');
        Route::get('/resetPassword', 'ViewPageController@resetPassword')->middleware('is.verify')->name('reset.password');

});
*/


Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers\Handler', 'middleware' => 'web'], function () {
    Route::get(config('swauth.viewRouteNames.step1.0'), 'ViewHandlerController@stepOneMethodZero')->name(config('swauth.viewRouteNames.step1.0'));
    Route::get(config('swauth.viewRouteNames.step1.1'), 'ViewHandlerController@stepOneMethodOne')->name(config('swauth.viewRouteNames.step1.1'));
    Route::get(config('swauth.viewRouteNames.step2.0'), 'ViewHandlerController@stepTwoMethodZero')->name(config('swauth.viewRouteNames.step2.0'));
    Route::get(config('swauth.viewRouteNames.step2.1'), 'ViewHandlerController@stepTwoMethodOne')->name(config('swauth.viewRouteNames.step2.1'));
    Route::get(config('swauth.viewRouteNames.step3.0'), 'ViewHandlerController@stepThreeMethodZero')->name(config('swauth.viewRouteNames.step3.0'));
    Route::get(config('swauth.viewRouteNames.step3.1'), 'ViewHandlerController@stepThreeMethodOne')->name(config('swauth.viewRouteNames.step3.1'));
    Route::get(config('swauth.viewRouteNames.step4.0'), 'ViewHandlerController@stepFourMethodZero')->name(config('swauth.viewRouteNames.step4.0'));
});

Route::group(['namespace' => 'MiladZamir\SweetAuth\Http\Controllers', 'middleware' => 'web'], function () {
    Route::post(config('swauth.postRouteNames.step1.0'), 'StepOneController@configure')->name(config('swauth.postRouteNames.step1.0'));
    Route::post(config('swauth.postRouteNames.step2.0'), 'StepTwoController@ReceiveRequest')->name(config('swauth.postRouteNames.step2.0'));
    Route::post(config('swauth.postRouteNames.step3.0'), 'StepThreeController@ReceiveRequest')->name(config('swauth.postRouteNames.step3.0'));
});

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'middleware' => 'web'], function () {
    Route::post(config('swauth.postRouteNames.step4.0'), 'LoginController@login')->name(config('swauth.viewRouteNames.step4.0'));
    Route::post(config('swauth.postRouteNames.step5.0'), 'LoginController@logout')->name(config('swauth.viewRouteNames.step5.0'));
});
