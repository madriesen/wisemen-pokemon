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
        list($property, $direction) = $this->getProperties($request);
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
        // validate request
        $limit = $request->query('limit') ?? 0;
        $query = $request->query('query') ?? '';
        if (!$query) {
            return [];
        }


        $pokemonsFilter = Pokemon::where('name', 'like', "%{$query}%")
            ->OrWhere('types', 'like', "%{$query}%");
        if ($limit) {
            $pokemonsFilter->limit($limit);
        }
        $pokemons = $pokemonsFilter->get();

        return $this->mapPokemonWithFrontDefaultSprite($pokemons);
    }

    public function getPaginated(Request $request)
    {
        $limit = $request->query('limit') ?? 20;
        $offset = $request->query('offset') ?? 0;
        $sort = $request->query('sort') ?? 'name-asc';
        list($property, $direction) = $this->getProperties($request);

        $pokemons = Pokemon::orderBy($property, $direction)->offset($offset)->limit($limit)->get();

        return [
            "data" => $this->mapPokemonWithFrontDefaultSprite($pokemons),
            'metadata' => $this->getMetadata($limit, $sort, $offset, $pokemons)
        ];
    }

    private function mapPokemonWithFrontDefaultSprite(Collection $pokemons)
    {
        return $pokemons->map(fn($pokemon) => [
            'id' => $pokemon->id,
            'name' => $pokemon->name,
            'sprites' => $pokemon->front_default,
            'types' => $pokemon->types,
        ]);
    }

    private function getProperties(Request $request): array
    {
        [$property, $direction] = explode('-', $request->query('sort') ?? 'name-asc');
        return array($property, $direction);
    }

    private function getMetadata(int $limit, string $sort, int $offset, Collection $pokemons): array
    {
        $baseUrl = '/api/pokemons?limit=' . $limit . '&sort=' . $sort . '&offset=';

        return [
            'next' => $baseUrl . ($offset + $limit),
            'previous' => $offset > 0 ? $baseUrl . ($offset - $limit) : null,
            'total' => $pokemons->count(),
            'pages' => ceil(Pokemon::count() / $limit),
            'page' => ceil($offset / $limit) + 1,
        ];
    }
}
