<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        return $teams->map(fn($team) => [
            'id' => $team->id,
            'name' => $team->name,
        ]);
    }
}
