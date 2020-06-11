<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;

class ThreadsFiltration
{
    public const SORTS = ['replies' => 'Less Commented', '-replies' => 'Most Commented', 'views' => 'Less Viewed', '-views' => 'Most Viewed'];
    public const SORT_PERIOD = [null => 'Overall', 'last_month' => 'Last Month', 'last_week' => 'Last Week'];

    public function compose(View $view)
    {
        $query = request()->query('sort');

        if (preg_match('([^_]+)', $query, $matches)) {
            $currentSort = $matches[0];
            $currentSortPeriod = str_replace("{$currentSort}_", null ,$query);
        }

        $view->with('currentSort', $currentSort ?? null);
        $view->with('currentSortPeriod', $currentSortPeriod ?? null);
        $view->with('sorts', self::SORTS);
        $view->with('sortPeriod', self::SORT_PERIOD);
    }
}
