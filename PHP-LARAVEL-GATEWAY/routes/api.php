<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('near')->group(function () {

    Route::get('/account/{accountId}', function ($accountId) {
        return NEAR::getAccount($accountId);
    })->name('near.account');

    Route::get('/{contractId}/get_all_offers', function ($contractId, Request $request) {
        return NEAR::getAllOffers($contractId, $request);
    })->name('near.ico.getAllOffers');

    Route::get('/{contractId}/get_offer', function ($contractId, Request $request) {
        return NEAR::getOffer($contractId, $request);
    })->name('near.ico.getOffer');

    Route::get('/{contractId}/get_ft_metadata', function ($contractId) {
        return NEAR::getFTMetadata($contractId);
    })->name('near.ico.getFTMetadata');

    Route::get('/{contractId}/get_storage_balance/{accountId}', function ($contractId, $accountId) {
        return NEAR::getStorageBalance($contractId, $accountId);
    })->name('near.ico.getStorageBalance');

    Route::get('/{contractId}/get_ft_balance/{accountId}', function ($contractId, $accountId) {
        return NEAR::getFTBalance($contractId, $accountId);
    })->name('near.ico.getFTBalance');
});

Route::fallback(function (){
    abort(404);
});

