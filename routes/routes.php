<?php

/**
 * Routes for the package would go here
 */

use Illuminate\Support\Facades\Route;

Route::view('/{any}', 'laravel-contacts-api::app')
     ->where('any', '.*');
