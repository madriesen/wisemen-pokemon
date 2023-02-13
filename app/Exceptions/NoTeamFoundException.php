<?php

namespace App\Exceptions;

use Exception;

class NoTeamFoundException extends Exception
{
    public function __construct(private int $id)
    {
        parent::__construct("No team found with id $id");
    }

    public function render()
    {
        return response()->json([
            'error' => 'Team not found',
            'error_message' => 'No team found with the id ' . $this->id,
        ], 404);
    }
}
