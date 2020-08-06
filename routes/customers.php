<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'customers.', 'namespace' => 'Client'], function(){
    Route::namespace('Api')->group(base_path('routes/api/customers.php'));
});
