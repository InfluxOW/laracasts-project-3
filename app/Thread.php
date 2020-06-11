<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Thread extends Model implements Viewable
{
    use InteractsWithViews;

    protected $fillable = ['body', 'title', 'channel_id', 'user_id', 'slug'];
    protected $with = ['channel', 'user'];
    protected $withCount = ['replies', 'repliesLastWeek', 'repliesLastMonth', 'views', 'viewsLastWeek', 'viewsLastMonth'];
    protected $removeViewsOnDelete = true;

    protected static function boot()
    {
        parent::boot();

        static::created(function($thread) {
            $thread->update(['slug' => slugify($thread->title)]);
        });
    }

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $reply = Auth::user()->replies()->make($reply);
        $this->replies()->save($reply);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // Helpers

    public function viewsLastWeek()
    {
        return $this->views()->where('viewed_at', '>=', now()->subWeek());
    }

    public function viewsLastMonth()
    {
        return $this->views()->where('viewed_at', '>=', now()->subMonth());
    }

    public function repliesLastWeek()
    {
        return $this->replies()->where('created_at', '>=', now()->subWeek());
    }

    public function repliesLastMonth()
    {
        return $this->replies()->where('created_at', '>=', now()->subMonth());
    }

    public function getImage()
    {
        return $this->image->url ?? "https://picsum.photos/seed/{$this->slug}/720/400";
    }

    public function recomendations()
    {
        return $this->channel->threads->filter(function($value, $key) {
            return !$this->is($value);
        })->random(min(3, count($this->channel->threads) - 1));
    }

}
