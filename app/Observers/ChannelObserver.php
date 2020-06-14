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

    /**
     * Handle the channel "restored" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function restored(Channel $channel)
    {
        //
    }

    /**
     * Handle the channel "force deleted" event.
     *
     * @param  \App\Channel  $channel
     * @return void
     */
    public function forceDeleted(Channel $channel)
    {
        //
    }
}
