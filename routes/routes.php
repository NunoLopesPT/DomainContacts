<?php

/**
 * Routes for the package would go here
 */

use Illuminate\Support\Facades\Route;
use NunoLopes\LaravelContactsAPI\Services\ContactsServices;

Route::resource('api/contacts', ContactsServices::class);

Route::view('/{any}', 'contacts::app')
     ->where('any', '.*');
