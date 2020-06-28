<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveEmptyQueryStringParams
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
        $queryString  = $request->getQueryString();
        if ($queryString) {
            $query = preg_replace('/[^=&]+=(?:&|$)/', '', $queryString);
            $url = "{$request->url()}?{$query}";
            if ($queryString !== $query) {
                return redirect($url);
            }
        }
        return $next($request);
    }
}
