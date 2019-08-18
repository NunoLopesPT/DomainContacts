<?php

use Illuminate\Support\Facades\Route;
use NunoLopes\DomainContacts\Controllers\AuthenticationController;
use NunoLopes\DomainContacts\Controllers\ContactsController;

Route::resource('contacts', ContactsController::class);

Route::group(['middleware' => ['json.response']], function () {
    Route::get('/user', AuthenticationController::class . '@user');
    Route::post('/login', AuthenticationController::class . '@login');
    Route::post('/register', AuthenticationController::class . '@register');
    Route::get('/logout', AuthenticationController::class . '@logout');
});
