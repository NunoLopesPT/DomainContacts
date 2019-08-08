<?php

use Illuminate\Support\Facades\Route;
use NunoLopes\LaravelContactsAPI\Controllers\AuthenticationController;
use NunoLopes\LaravelContactsAPI\Controllers\ContactsController;

Route::resource('contacts', ContactsController::class);

Route::group(['middleware' => ['json.response']], function () {
    Route::get('/user', AuthenticationController::class . '@user');
    Route::post('/login', AuthenticationController::class . '@login');
    Route::post('/register', AuthenticationController::class . '@register');
    Route::get('/logout', AuthenticationController::class . '@logout');
});
