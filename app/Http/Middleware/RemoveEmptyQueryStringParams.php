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
        $query  = collect($request->query());
        $queryContainsOnlyNotNullValues = $query->every(function ($value) {
            return ! is_null($value);
        });

        if (! $queryContainsOnlyNotNullValues) {
            $queryWithNoEmptyValues = $query->filter(function ($value) {
                return ! is_null($value);
            })->toArray();
            $url = $request->fullUrlWithQuery($queryWithNoEmptyValues);

            return redirect($url);
        }

        return $next($request);
    }
}
