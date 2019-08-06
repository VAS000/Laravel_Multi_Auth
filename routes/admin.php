<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // config()->set('auth.defaults.guard', 'admin');

    Route::get('login', 'AdminAuth@login');
    Route::post('login', 'AdminAuth@postLogin');
    Route::get('forgot/password', 'AdminAuth@forgetPassword');
    Route::post('forgot/password', 'AdminAuth@postForgetPassword');
    Route::get('/reset/password/{token}', 'AdminAuth@resetPassword');
    Route::post('/reset/password', 'AdminAuth@postResetPassword');

    Route::group(['middleware' => 'admin:admin'], function () {

        Route::resource('admin', 'AdminController');

        Route::get('/', function() {
            return view('admin.home');
        });

        Route::post('logout', 'AdminAuth@postLogout');

    });

    Route::get('/lang/{lang}', function($lang) {
        session()->has('lang')? session()->forget('lang'): '';
        session()->put('lang', $lang);
        return back();
    });


});
