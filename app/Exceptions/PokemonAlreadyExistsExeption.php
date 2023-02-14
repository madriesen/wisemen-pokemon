<?php

namespace App\Exceptions;

use Exception;

class PokemonAlreadyExistsExeption extends Exception
{
    public function __construct(private string $name)
    {
        parent::__construct("Pokemon already exists");
    }

    public function render()
    {
        return response()->json([
            'error' => 'Pokemon already exists',
            'error_message' => 'The pokemon with name: "' . $this->name . '" already exists',
        ], 400);
    }
}
