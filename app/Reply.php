<?php

namespace App;

use App\User;
use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['body', 'thread_id', 'user_id'];

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
