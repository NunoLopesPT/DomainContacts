<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use NunoLopes\LaravelContactsAPI\Controllers\AuthenticationController;
use NunoLopes\LaravelContactsAPI\Controllers\ContactsController;

// Having auth:api as middleware, if the user is not logged in, it will throw an
// 401 Unauthorized Exception.
Route::resource('contacts', ContactsController::class)
      ->middleware('auth:api');

Route::group(['middleware' => ['json.response']], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // public routes
    Route::post('/login', AuthenticationController::class . '@login')->name('login.api');
    Route::post('/register', AuthenticationController::class . '@register')->name('register.api');

    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', AuthenticationController::class . '@logout')->name('logout');
    });

});
