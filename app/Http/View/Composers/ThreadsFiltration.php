<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;

class ThreadsFiltration
{
    public const SORTS = [
        'replies' => 'Less Commented', '-replies' => 'Most Commented',
        'views' => 'Less Viewed', '-views' => 'Most Viewed',
        'favorites' => 'Less Favorited', '-favorites' => 'Most Favorited'
    ];

    public function compose(View $view)
    {
        $view->with('currentSort', request()->query('sort'));
        $view->with('sortFromDate', request()->query('sort_from_date'));

        $view->with('sorts', self::SORTS);
    }
}
