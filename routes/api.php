<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\server;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'address', 'as' => 'address'], function () {
    Route::get('province', 'AddressController@province')->name('province');
    Route::get('district', 'AddressController@district')->name('district');
    Route::get('ward', 'AddressController@ward')->name('ward');
    // Route::resource('service', 'ServiceController')->only('index');
});
