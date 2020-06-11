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
        if ($request->has(['sort_period', 'sort'])) {
            $periodQuery = $request->query('sort_period');
            $sortQuery = $request->query('sort');
            $sort = empty($periodQuery) ? $sortQuery : "{$sortQuery}_{$periodQuery}";

            return redirect()->route('threads.index', ['sort' => $sort]);
        }

        return $next($request);
    }
}
