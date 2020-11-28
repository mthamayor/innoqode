<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonOnly
{
    /**
     * Accept only JSON requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        if (
            !$request->isMethod('post') && !$request->isMethod('patch') && !$request->isMethod('put')
        ){
            return $next($request);
        }

        $acceptHeader = $request->header('Content-Type');

        if ($acceptHeader != 'application/json') {
            return response()->json([
                'message' => 'Not Acceptable.',
                'errors' => [
                    'Request should be of type "application/json".'
                ]
            ], 406);
        }

        return $next($request);
    }
}
