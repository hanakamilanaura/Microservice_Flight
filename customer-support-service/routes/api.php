<?php

use App\Http\Controllers\Api\CustomerSupportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\GraphQLController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Now create something great!
|
*/

Route::apiResource('customer_supports', CustomerSupportController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// GraphQL endpoint
Route::post('/graphql', [GraphQLController::class, 'handle']);
