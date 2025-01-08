<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::namespace('App\Http\Controllers')->group(function(){    //since they use common route App\Http\Controllers
   //GET API - Getch one or more records
   Route::get('users/{id?}', [APIController::class, 'getUsers']);

    // Secure GET API - Fetch one or more records
    Route::get('users-list', [APIController::class, 'getUsersList']);

    // GET API - Fetch categories
    Route::get('categories', [APIController::class, 'getCategories']);

    // POST API - Add a single user
    Route::post('add-users', [APIController::class, 'addUsers']);

    // POST API - Add multiple users
    Route::post('add-multiple-users', [APIController::class, 'addMultipleUsers']);

    // POST API - Register user with API token
    Route::post('register-user', [APIController::class, 'registerUser']);

    // PUT API - Update one or more records
    Route::put('update-user-details', [APIController::class, 'updateUserDetails']);

    // PATCH API - Update a single record
    Route::patch('update-user-name/{id}', [APIController::class, 'updateUserName']);

    // DELETE API - Delete a single user
    Route::delete('delete-user/{id}', [APIController::class, 'deleteUser']);

    // DELETE API - Delete a single user with JSON payload
    Route::delete('delete-user-with-json', [APIController::class, 'deleteUserWithJson']);

    // DELETE API - Delete multiple users by parameters
    Route::delete('delete-multiple-users/{ids}', [APIController::class, 'deleteMultipleUsers']);

    // DELETE API - Delete multiple users with JSON payload
    Route::delete('delete-multiple-users-json', [APIController::class, 'deleteMultipleUsersWithJson']);
});

