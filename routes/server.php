<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'server.', 'namespace' => 'Server'], function() {
    Route::group(['as' => 'Api'], function() {
    	Route::post('login', 'Auth\AuthenticateController@login')->name('login');
        Route::group(['middleware' => ['assign.jwt:api_admin']], function () {
            Route::resource('branch_salons', 'BranchSalonController')->except(['create']);
            Route::post('profile', 'ProfileController@update')->name('profile.update');
            Route::resource('branch_salons', 'BranchSalonController')->except(['create', 'edit']);
            Route::resource('service', 'ServiceController')->except(['create', 'edit']);
            Route::resource('reviews', 'ReviewController')->except('create');
        });
    });
});
