<?php

namespace App;

use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Thread extends Model implements Viewable
{
    use InteractsWithViews;
    use Favoriteable;

    protected $fillable = ['body', 'title', 'channel_id', 'user_id', 'slug'];
    protected $with = ['channel', 'user', 'favorites'];
    protected $removeViewsOnDelete = true;
    public const COUNTABLES = ['replies', 'views', 'favorites'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($thread) {
            $thread->update(['slug' => slugify($thread->title)]);
        });

        static::addGlobalScope("countablesCount", function($builder) {
            if (is_null(request()->sort_from_date)) {
                $builder->withCount(Thread::COUNTABLES);
            } else {
                foreach(Thread::COUNTABLES as $property) {
                    $builder->withCount([$property => function($query) {
                        $sortFromDate = Carbon::createFromDate(request()->sort_from_date);
                        $query->where('created_at', '>=', $sortFromDate);
                    }]);
                }
            }
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

    public function getImage()
    {
        return $this->image->url ?? "https://picsum.photos/seed/{$this->slug}/720/400";
    }

    public function recomendations()
    {
        return $this->channel->threads->filter(function($value, $key) {
            return ! $this->is($value);
        })->random(min(3, count($this->channel->threads) - 1));
    }

}
