<?php

use App\Http\Controllers\TourController;
use App\Http\Controllers\ExcursionController;
use App\Http\Controllers\OrderController;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\Excursion;
use App\Models\ExcursionDate;
use App\Http\Resources\ExcursionResource;
use OpenApi\Annotations as OA;

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

/**
 * @OA\Get(
 *     path="/api/tours",
 *     @OA\Response(response="200", description="Welcome page")
 * )
 */
Route::middleware('auth:sanctum')->get('/tours', 'App\Http\Controllers\TourController@index');

Route::middleware('auth:sanctum')->get('/excursions', 'App\Http\Controllers\ExcursionController@index');

Route::middleware('auth:sanctum')->get('/tours/availability', 'App\Http\Controllers\TourController@getToursAvailability');

Route::middleware('auth:sanctum')->get('/excursions/availability', 'App\Http\Controllers\ExcursionController@getExcursionsAvailability');

Route::middleware('auth:sanctum')->get('/tours/{id}', 'App\Http\Controllers\TourController@getTour');

Route::middleware('auth:sanctum')->get('/excursions/{id}', 'App\Http\Controllers\ExcursionController@getExcursion');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::post('/orders', [OrderController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
