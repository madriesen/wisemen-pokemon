<?php

namespace App\Http\Controllers;

use App\Exceptions\NoPokemonFoundException;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        [$property, $direction] = explode('-', $request->query('sort') ?? 'name-asc');
        $pokemons = Pokemon::orderBy($property, $direction)->get();

        return $pokemons->map(fn($pokemon) => [
            'id' => $pokemon->id,
            'name' => $pokemon->name,
            'sprites' => $pokemon->front_default,
        ]);
    }

    public function show(int $id)
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            throw new NoPokemonFoundException($id);
        }

        return [
            'id' => $pokemon->id,
            'name' => $pokemon->name,
            'sprites' => $pokemon->sprites,
        ];
    }
}
