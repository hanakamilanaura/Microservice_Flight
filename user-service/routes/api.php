<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\GraphQL\Controller\GraphQLController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Now create something great!
|
*/
Route::apiResource('users', UserController::class)->except([
    'getBookings'
]);

Route::get('users/{id}/bookings', [UserController::class, 'getBookings']);

Route::post('/graphql', [GraphQLController::class, 'handle']);
