<?php

use App\Http\Controllers\ExternalPokemonController;
use App\Http\Controllers\PokemonController;
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
Route::group([
    'prefix' => 'pokemons',
], function () {
    Route::get('/', [PokemonController::class, 'getPaginated']);
    Route::post('/import', [ExternalPokemonController::class, 'import']);
});

