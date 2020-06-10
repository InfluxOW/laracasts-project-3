<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Thread extends Model implements Viewable
{
    use InteractsWithViews;

    protected $fillable = ['body', 'title', 'channel_id', 'user_id'];
    protected $with = ['channel', 'user'];
    protected $withCount = ['replies', 'views'];

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
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

    public function getImage()
    {
        return $this->image->url ?? "https://picsum.photos/seed/{$this->slug}/720/400";
    }

    public function getSlugAttribute()
    {
        return slugify($this->title);
    }

    public function randomThreadsInTheSameChannel()
    {
        return $this->channel->threads->filter(function($value, $key) {
            return $value !== $this;
        })->random(min(3, count($this->channel->threads) - 1));
    }
}
