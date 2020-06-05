<?php

namespace App\Http\ViewComposers;

use App\Channel;
use Illuminate\View\View;

class Channels
{
    public function compose(View $view)
    {
        $channels = Channel::all();

        $view->with('channels', $channels);
    }
}
