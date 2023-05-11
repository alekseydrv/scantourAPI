<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', 'App\Http\Controllers\TourController@index');
/**
 * @OA\Get(
 *     path="/",
 *     @OA\Response(response="200", description="Welcome page")
 * )
 */
Route::apiResource('/', TourController::class);



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
