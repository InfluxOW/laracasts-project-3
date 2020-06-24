<?php

namespace App\Events;

use App\Reply;
use App\Thread;
use Illuminate\Queue\SerializesModels;

class ReplyCreated
{
    use SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @param Reply $reply
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }
}
