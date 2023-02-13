<?php

namespace App\Http\Controllers;

use App\Exceptions\NoPokemonFoundException;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        [$property, $direction] = explode('-', $request->query('sort') ?? 'name-asc');
        $pokemons = Pokemon::orderBy($property, $direction)->get();

        return $this->mapPokemonWithFrontDefaultSprite($pokemons);
    }

    public function show(int $id)
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            throw new NoPokemonFoundException($id);
        }

        return $pokemon->toArray();
    }

    public function search(Request $request)
    {
        $query = $request->query('query') ?? '';
        $limit = $request->query('limit') ?? 0;
        $pokemonsFilter = Pokemon::where('name', 'like', "%{$query}%")
            ->OrWhere('types', 'like', "%{$query}%");
        if ($limit) {
            $pokemonsFilter->limit($limit);
        }
        $pokemons = $pokemonsFilter->get();

        return $this->mapPokemonWithFrontDefaultSprite($pokemons);
    }

    /**
     * @param Collection<Pokemon> $pokemons
     * @return mixed
     */
    public function mapPokemonWithFrontDefaultSprite(Collection $pokemons)
    {
        return $pokemons->map(fn($pokemon) => [
            'id' => $pokemon->id,
            'name' => $pokemon->name,
            'sprites' => $pokemon->front_default,
            'types' => $pokemon->types,
        ]);
    }
}
