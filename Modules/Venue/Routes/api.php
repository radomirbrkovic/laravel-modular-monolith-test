<?php

use Illuminate\Http\Request;
use Modules\Venue\Http\Controllers\Api\VenueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('venue', VenueController::class)->except(['create', 'edit']);

