<?php

namespace App;

use App\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Thread extends Model
{
    protected $fillable = ['body', 'title', 'channel_id', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->where('thread_id', $this->id);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    //

    public function addReply($reply)
    {
        $reply = Auth::user()->replies()->make($reply);
        $this->replies()->save($reply);
    }
}
