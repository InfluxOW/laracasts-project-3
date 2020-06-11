<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class ThreadsCard
{
    public function compose(View $view)
    {
        $query = request()->query('sort');
        preg_match('([^_]+)', $query, $matches);
        $sortPeriod = str_replace($matches[0] ?? null, null ,$query);

        $viewsCount = "views{$sortPeriod}_count";
        $repliesCount = "replies{$sortPeriod}_count";

        $view->with('viewsCount', $viewsCount);
        $view->with('repliesCount', $repliesCount);
    }
}
