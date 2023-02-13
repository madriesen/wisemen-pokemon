<?php

namespace App\Exceptions;

use Exception;

class NoPokemonFoundException extends Exception
{
    public function __construct(private int $id)
    {
        parent::__construct("No pokemon found with id $id");
    }

    public function render()
    {
        return response()->json([
            'error' => 'Pokemon not found',
            'error_message' => 'No Pokemon found with the id ' . $this->id,
        ], 404);
    }
}
