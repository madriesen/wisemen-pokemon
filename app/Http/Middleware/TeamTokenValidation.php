<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class TeamTokenValidation
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization') !== 'my-team-token')
            return abort(401);
        return $next($request);
    }
}
