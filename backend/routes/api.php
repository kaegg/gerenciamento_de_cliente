<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ClientController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/professions', [ProfessionController::class, 'store']);
Route::get('/professions' , [ProfessionController::class, 'index']);

Route::post('/addresses', [AddressController::class, 'store']);
Route::get('/addresses' , [AddressController::class, 'index']);

Route::apiResource('clients', ClientController::class);