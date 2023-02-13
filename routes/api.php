<?php

use App\Http\Controllers\PokemonController;
use App\Http\Controllers\TeamController;
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

Route::get('heartbeat', function () {
    return response()->json([
        'message' => 'Welcome to the API',
    ]);
});

Route::group([
    'prefix' => 'pokemons',
], function () {
    Route::get('/', [PokemonController::class, 'index']);
    Route::get('/{pokemon}', [PokemonController::class, 'show']);
});

Route::group([
    'prefix' => 'teams',
], function () {
    Route::get('/', [TeamController::class, 'index']);
});
