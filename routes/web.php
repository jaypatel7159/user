<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('users', [UserController::class, 'index']);
Route::get('get-users', [UserController::class, 'getUsers']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);
Route::get('/get-countries', [UserController::class, 'getCountries']);
Route::get('/get-states/{country_id}', [UserController::class, 'getStates']);
Route::get('/get-cities/{state_id}', [UserController::class, 'getCities']);


