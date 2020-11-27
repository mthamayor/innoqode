<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UpdateUsernameNonExisting
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
        $id = $request->route('id');

        $user =  User::where('username', $request->username )->where('id', '!=', $id)->first();

        if ($user) {
            return response()->json([
                'message' => 'Conflict.',
                'errors' => [
                    'username' => 'Username taken.'
                ]
            ], 409);
        };
        return $next($request);
    }
}
