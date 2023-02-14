<?php

namespace App\Exceptions;

use Exception;

class NoPokemonFoundException extends Exception
{
    public function __construct(private int $id, private string $name = '')
    {
        parent::__construct("No pokemon found with id $id or name $name");
    }

    public function render()
    {
        $errorMessage = 'No Pokemon found';
        if ($this->id) {
            $errorMessage .= ' with id ' . $this->id;
        } elseif ($this->name) {
            $errorMessage .= ' with name ' . $this->name;
        }
        return response()->json([
            'error' => 'Pokemon not found',
            'error_message' => $errorMessage
        ], 404);
    }
}
