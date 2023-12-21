<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\AuthentitationControler;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthentitationControler::class, 'me']);
    Route::get('/logout', [AuthentitationControler::class, 'logout']);

    Route::get('/about-customer', [CustomerController::class, 'about']);
    Route::get('/logout-customer', [CustomerController::class, 'logout']);
    
    Route::resource('/products', ProductController::class)->middleware('checkPenjual');
    Route::resource('/orders', OrderController::class);
});

Route::post('/login', [AuthentitationControler::class, 'login']);
Route::post('/login-customer', [CustomerController::class, 'login']);
Route::post('/register-customer', [CustomerController::class, 'register']);
Route::post('/register', [AuthentitationControler::class, 'register']);

