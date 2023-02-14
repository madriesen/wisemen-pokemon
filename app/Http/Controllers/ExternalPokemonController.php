<?php

namespace App\Http\Controllers;

use App\Exceptions\NoPokemonFoundException;
use App\Exceptions\PokemonAlreadyExistsExeption;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use InvalidArgumentException;
use PokePHP\PokeApi;

class ExternalPokemonController extends Controller
{
    public function import(Request $request)
    {
        $api = new PokeApi();

        $param = $this->sanitizeRequestParams($request);

        $pokemon = json_decode($api->pokemon($param));

        $this->validatePokemonApiResponse($pokemon, $param);

        list($sprites, $types) = $this->sanitizeResult($pokemon);

        $pokemon = Pokemon::create([
            'name' => $pokemon->name,
            "sprites" => $sprites,
            "types" => $types,
        ]);

        return response()->json([
            $pokemon
        ], 201);
    }

    /**
     * @param mixed $pokemon
     * @param array|string|null $param
     * @return void
     * @throws NoPokemonFoundException
     * @throws PokemonAlreadyExistsExeption
     */
    public function validatePokemonApiResponse(mixed $pokemon, array|string|null $param): void
    {
        if (!$pokemon || !isset($pokemon->name)) {
            throw new NoPokemonFoundException(0, $param);
        }

        if (Pokemon::where('name', $pokemon->name)->first()) {
            throw new PokemonAlreadyExistsExeption($pokemon->name);
        }
    }

    /**
     * @param mixed $pokemon
     * @return array
     */
    public function sanitizeResult(mixed $pokemon): array
    {
        $sprites = Pokemon::sanitizeSprites($pokemon);
        $types = Pokemon::sanitizeTypes($pokemon);
        return array($sprites, $types);
    }

    /**
     * @param Request $request
     * @return array|string
     * @throws PokemonAlreadyExistsExeption
     */
    public function sanitizeRequestParams(Request $request): string|array
    {
        $param = strtolower($request->query('name')) ?? $request->query('externalId') ?? null;

        if (!$param) {
            throw new InvalidArgumentException('No name or externalId provided');
        }

        if (Pokemon::where('name', $param)->first()) {
            throw new PokemonAlreadyExistsExeption($param);
        }
        return $param;
    }
}
