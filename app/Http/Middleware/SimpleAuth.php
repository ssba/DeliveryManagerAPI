<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;
use Cache;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;

class SimpleAuth
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
        if (Config::get('app.debug'))
            return $next($request);

        $routeRole = Route::getCurrentRoute()->action['role'];
        if(!is_array($routeRole))
            $routeRole = [$routeRole];

        if (in_array('*', $routeRole))
            return $next($request);

        try{
            $session = Cache::get("user.session.".$request->token);

            if (is_null($session))
                throw new \Exception();

            $user = User::where('guid', $session['user'])->firstOrFail();
            $userRole = $user->role->type;

            if($userRole == $routeRole || $userRole == "root")
                return $next($request);

        } catch (\Exception $e){
            throw new AuthorizationException();
        }



    }
}
