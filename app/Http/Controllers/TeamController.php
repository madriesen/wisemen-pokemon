<?php

namespace App\Http\Controllers;

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
}
