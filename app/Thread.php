<?php

namespace App;

use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;

class Thread extends Model implements Viewable
{
    use InteractsWithViews;
    use Favoriteable;
    use LogsActivity;

    protected $fillable = ['body', 'title', 'channel_id', 'user_id', 'slug'];
    protected $with = ['channel', 'user', 'favorites'];
    public const COUNTABLES = ['replies', 'views', 'favorites'];
    // views
    protected $removeViewsOnDelete = true;
    // logs
    protected static $logAttributes = ['body', 'title', 'channel.name'];
    protected static $logName = 'threads_log';
    protected static $ignoreChangedAttributes = ['updated_at', 'slug'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("countablesCount", function ($builder) {
            if (is_null(request()->sort_from_date)) {
                $builder->withCount(Thread::COUNTABLES);
            } else {
                foreach (Thread::COUNTABLES as $property) {
                    $builder->withCount([$property => function ($query) {
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

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // Helpers

    public function getImage()
    {
        return $this->image->url ?? "https://picsum.photos/seed/{$this->slug}/720/400";
    }

    public function getRecomendationsAttribute()
    {
        $recomendationsAmount = min(3, $this->channel->threads_count - 1);
        return $this->channel->threads->where('id', '<>', $this->id)->random($recomendationsAmount);
    }

    public function addReply($reply)
    {
        $reply = Auth::user()->replies()->make($reply);
        $this->replies()->save($reply);
        return $reply;
    }
}
