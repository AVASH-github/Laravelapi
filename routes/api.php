<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::namespace('App\Http\Controllers')->group(function(){    //since they use common route App\Http\Controllers
   //GET API - Getch one or more records
    Route::get('users/{id?}','APIController@getUsers');

    //Secure GET API - Getch one or more records
    Route::get('users-list','APIController@getUsersList');

Route::get('categories','APIController@getCategories');

//POST API - Add single user
Route::post('add-users','APIController@addUsers');

//POST API- Add multiple users

Route::post('add-multiple-users','APIController@addMultipleUsers');

//PUT API -Update one or more records
Route::put('update-user-details','APIController@updateUserDetails');

// PATCH API - Update single record 

Route::patch ('update-user-name/{id}','APIController@updateUserName');


// DELETE API - Delete single user

Route::delete('delete-user/{id}','APIController@deleteUser');

//DELETE API- Delete single user with json 
Route::delete('delete-user-with-json','APIController@deleteUserWithJson');

//DELETE API- Delete multiple users with param

Route::delete('delete-multiple-users/{ids}','APIController@deleteMultipleUsers');

//DELETE API- Delete multiple users with json 


Route::delete('delete-multiple-users-json','APIController@deleteMultipleUsersWithJson');
});

