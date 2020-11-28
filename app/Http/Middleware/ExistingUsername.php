<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ExistingUsername
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user =  User::where('username', $request->username)->first();

        if ($user) {
            return response()->json([
                'message' => 'Conflict.',
                'errors' => [
                    'username' => [ 'User with username already exists.' ]
                ]
            ], 409);
        };
        return $next($request);
    }
}
