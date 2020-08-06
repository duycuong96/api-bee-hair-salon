<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'Auth\AuthenticateController@login')->name('login');
Route::post('register', 'Auth\AuthenticateController@register')->name('register');
Route::post('forgot','Auth\ForgotController@forgotPassword')->name('forgot');
Route::post('forgot/reset','Auth\ForgotController@resetPassword')->name('reset.password');


Route::group(['middleware' => ['assign.jwt:api_customers']], function() {

    Route::get('', 'ProfileController@index');

    Route::post('profile', 'ProfileController@update')->name('profile.update');
    Route::put('profile/password', 'ProfileController@changePassword')->name('profile.password');

    Route::get('logout', 'Auth\AuthenticateController@logout')->name('logout');
    Route::get('reviews_customer', 'ReviewController@findReviewsCustomer');
});

Route::resource('branch_salons', 'BranchSalonController')->only(['index', 'show']);
Route::resource('service', 'ServiceController')->only(['index', 'show']);
Route::get('reviews_salon/{salon_id?}', 'ReviewController@findReviewsSalon');
Route::post('contacts', 'ContactController@sendContact');


