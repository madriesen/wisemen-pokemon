<?php

namespace App\Http\Controllers;

use App\Exceptions\NoTeamFoundException;
use App\Http\Requests\AssignPokemonToTeamRequest;
use App\Http\Requests\CreateTeamRequest;
use App\Models\Pokemon;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return Response()->json(Team::all(), 200);
    }

    public function create(CreateTeamRequest $request)
    {
        [$name] = $request->validated();
        $team = Team::create([
            'name' => $name,
        ]);

        return Response()->json($team->toArray(), 201);
    }

    public function show(int $id)
    {
        $team = Team::find($id);

        if (!$team) {
            throw new NoTeamFoundException($id);
        }

        return $team->toArray();
    }

    public function assignPokemon(AssignPokemonToTeamRequest $request, $team_id)
    {
        ["pokemons" => $pokemons] = $request->validated();
        $team = Team::find($team_id);
        if (!$team) {
            throw new NoTeamFoundException($team_id);
        }
        $pokemonModels = Pokemon::whereIn('id', $pokemons)->get();
        $team->pokemons()->saveMany($pokemonModels);

        return Response()->json($team->toArray(), 200);
    }
}
