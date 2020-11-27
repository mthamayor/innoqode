<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class NonExistingUser
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

        $user =  User::where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Not found.',
                'errors' => [
                    'id' => 'User with id does not exist.'
                ]
            ], 404);
        };

        return $next($request);
    }
}
