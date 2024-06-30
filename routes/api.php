<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('booking',[BookingController::class,'booking']);

    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'login']);

});


Route::get('/slots', [SlotController::class, 'index']);

Route::group(['middleware' => 'api'], function() {
    // Retrieve available slots for booking


    // Create a new booking
    Route::post('bookings', [BookingController::class, 'store']);

    // Retrieve all bookings for the logged-in user
    Route::get('bookings', [BookingController::class, 'index']);
    
    Route::get('show', [BookingController::class, 'show']);


    // Cancel a booking by ID
    Route::delete('bookings/{id}/destroy', [BookingController::class, 'destroy']);
});