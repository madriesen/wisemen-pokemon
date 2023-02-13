<?php

namespace App\Http\Controllers;

use App\Exceptions\NoTeamFoundException;
use App\Http\Requests\CreateTeamRequest;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return Response()->json(Team::all(), 200);
    }

    public function create(CreateTeamRequest $request)
    {
        $team = Team::create([
            'name' => $request->name,
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
}
