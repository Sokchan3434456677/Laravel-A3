<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;

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

Route::prefix('public')->group(function () {
    // GET all lists
    Route::get('/lists', [ListController::class, 'apiIndex']);

    // GET single list
    Route::get('/lists/{id}', [ListController::class, 'apiShow']);

    // POST create new list
    Route::post('/lists', [ListController::class, 'apiStore']);

    // PUT update list
    Route::put('/lists/{id}', [ListController::class, 'apiUpdate']);

    // DELETE list
    Route::delete('/lists/{id}', [ListController::class, 'apiDestroy']);
});
