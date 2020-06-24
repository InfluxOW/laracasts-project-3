<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use App\Traits\Subscribable;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class Thread extends Model implements Viewable
{
    use InteractsWithViews;
    use Favoriteable;
    use LogsActivity;
    use Subscribable;

    protected $fillable = ['body', 'title', 'channel_id', 'user_id', 'slug', 'created_at'];
    protected $with = ['channel', 'user', 'favorites'];
    public const COUNTABLES = ['replies', 'views', 'favorites'];
    // views
    protected $removeViewsOnDelete = true;
    // logs
    protected static $logAttributes = ['body', 'title'];
    protected static $logName = 'threads_log';
    protected static $ignoreChangedAttributes = ['updated_at', 'slug'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $recordEvents = ['created', 'updated'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("countablesCount", function ($builder) {
//            if (is_null(request()->sort_from_date)) {
                $builder->withCount(Thread::COUNTABLES);
//            } else {
//                foreach (Thread::COUNTABLES as $property) {
//                    $builder->withCount([$property => function ($query) {
//                        $sortFromDate = Carbon::createFromDate(request()->sort_from_date);
//                        $query->where('created_at', '>=', $sortFromDate);
//                    }]);
//                }
//            }
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

    public function addReply($reply, $user)
    {
        $reply = $user->replies()->make($reply);
        $this->replies()->save($reply);

        $this->subscriptions
            ->filter(function ($subscription) use ($user) {
            return $subscription->user->isNot($user);
        })
            ->each( function ($subscription) use ($reply) {
            $subscription->user->notify(new ThreadWasUpdated($reply));
        });

        return $reply;
    }

    public function scopeCreatedAfter(Builder $query, $date): Builder
    {
        return $query->where('created_at', '>=', Carbon::parse($date));
    }

    public static function buildQuery($query)
    {
        return QueryBuilder::for($query)
            ->allowedFilters([
                'user.username',
                AllowedFilter::scope('created_after'),
            ])
            ->allowedSorts([
                AllowedSort::field('views', 'views_count'),
                AllowedSort::field('replies', 'replies_count'),
                AllowedSort::field('favorites', 'favorites_count'),
            ])
            ->latest();
    }

    public function getLinkAttribute()
    {
        return $this->getLink();
    }

    public function getLink(): string
    {
        return route('threads.show', [$this->channel, $this]);
    }
}
