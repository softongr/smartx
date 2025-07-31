<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'api_key'])->group(function () {

    Route::get('products', \App\Http\Controllers\Api\V1\Products\Index::class . '@index');
});

