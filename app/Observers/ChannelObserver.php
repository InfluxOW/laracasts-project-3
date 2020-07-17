<?php

namespace App\Observers;

use App\Channel;
use Illuminate\Support\Facades\Cache;

class ChannelObserver
{
    /**
     * Handle the channel "created" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function created(Channel $channel)
    {
        Cache::forget('channels');
        $channel->update(['slug' => $channel->name]);
    }

    /**
     * Handle the channel "updated" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function updated(Channel $channel)
    {
        Cache::forget('channels');

        if ($channel->slug !== slugify($channel->name)) {
            $channel->update(['slug' => $channel->name]);
        }
    }

    /**
     * Handle the channel "deleted" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function deleted(Channel $channel)
    {
        Cache::forget('channels');
    }
}
