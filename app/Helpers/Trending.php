<?php

namespace App\Helpers;

use App\Thread;
use Illuminate\Support\Facades\Redis;

class Trending
{
    /**
     * Fetch all trending threads.
     *
     * @return array
     */
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 2));
    }

    /**
     * Get the cache key name.
     *
     * @return string
     */
    public function cacheKey()
    {
        return 'trending_threads';
    }

    /**
     * Push a new thread to the trending list.
     *
     * @param Thread $thread
     */
    public function push(Thread $thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'link' => $thread->link
        ]));
    }

    /**
     * Reset all trending threads.
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }
}
