<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        [$property, $direction] = explode('-', $request->query('sort') ?? 'name-asc');
        return Pokemon::orderBy($property, $direction)->get();
    }
}
