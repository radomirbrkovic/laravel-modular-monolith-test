<?php

use Modules\Payment\Http\Controllers\Api\TicketPurchaseController;

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

Route::post('events/{event_id}/purchase', [TicketPurchaseController::class, 'store'])->name('events.purchase.store');
