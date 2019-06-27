<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // config()->set('auth.defaults.guard', 'admin');

    Route::get('login', 'AdminAuth@login');
    Route::post('login', 'AdminAuth@postLogin');

    Route::group(['middleware' => 'admin:admin'], function () {
        Route::get('/', function() {
            return view('admin.home');
        });

        Route::post('logout', 'AdminAuth@postLogout');

    });


});
