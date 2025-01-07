<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::namespace('App\Http\Controllers')->group(function(){    //since they use common route App\Http\Controllers
   //GET API - Getch one or more records
    Route::get('users/{id?}','APIController@getUsers');

Route::get('categories','APIController@getCategories');

//POST API - Add single user
Route::post('add-users','APIController@addUsers');

//POST API- Add multiple users

Route::post('add-multiple-users','APIController@addMultipleUsers');

});

