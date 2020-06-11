<?php

namespace App\Http\Middleware;

use Closure;

class AppliesSort
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
        if ($request->has('sort_period') && $request->has('sort')) {
            $periodQuery = empty($request->query('sort_period')) ? '' : "_{$request->query('sort_period')}";
            $sort = "{$request->query('sort')}{$periodQuery}";

            return redirect()->route('threads.index', ['sort' => $sort]);
        }

        return $next($request);
    }
}
