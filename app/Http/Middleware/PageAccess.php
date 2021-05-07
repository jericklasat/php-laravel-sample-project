<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PageAccess
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

        if (auth()->check()){
            $available_routes = [
                1 => ['home', 'user_profile', 'logout', 'user'],
                57 => ['home', 'user_profile', 'logout', 'admin']
            ];

            /**
             * TODO:
             *   Check user level
             *   If current route is in the available routes
             *      Yes
             *          Continue
             *      No
             *          Redirect to home
             */
            if (\in_array($request->route()->getName(), $available_routes[auth()->user()->level])) {
                return $next($request);
            } else {
                return \redirect('/home');
            }
        }
        return $next($request);
    }
}
