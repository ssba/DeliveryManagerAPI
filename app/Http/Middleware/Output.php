<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;

class Output
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $JsonOptions = 0;

        if(!is_null($response->exception))
            return $response;

        if(Config::get('app.debug', false))
            $JsonOptions = JSON_NUMERIC_CHECK | JSON_BIGINT_AS_STRING | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

        switch (current(Route::getCurrentRoute()->methods)){
            case 'POST':
                $StatusCode = 201;
                break;
            default:
                $StatusCode = $response->getStatusCode();
                break;
        }

        return response()->json($response->getOriginalContent(), $StatusCode, [], $JsonOptions);
    }
}