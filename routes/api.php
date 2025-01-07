<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('users/{id?}','App\Http\Controllers\APIController@getUsers');

Route::get('categories','App\Http\Controllers\APIController@getCategories');
