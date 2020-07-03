<?php

namespace App;

use App\Traits\Subscribable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class Thread extends Model
{
    use Favoriteable;
    use LogsActivity;
    use Subscribable;

    protected $appends = ['views_count'];
    protected $fillable = ['body', 'title', 'channel_id', 'user_id', 'slug', 'created_at', 'best_reply_id'];
    protected $with = ['channel', 'user', 'favorites'];
    protected $withCount = ['favorites', 'replies'];
    // logs
    protected static $logAttributes = ['body', 'title'];
    protected static $logName = 'threads_log';
    protected static $ignoreChangedAttributes = ['updated_at', 'slug'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $recordEvents = ['created', 'updated'];

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

    public function getViewsCountAttribute()
    {
        return isset($this->id) ? $this->visit()->count() : 0;
    }

    public function visit()
    {
        return visits($this);
    }

    public function addReply($reply, $user)
    {
        $reply = $user->replies()->make($reply);
        $this->replies()->save($reply);

        return $reply;
    }

    public function scopeCreatedAfter(Builder $query, $date): Builder
    {
        return $query->where('created_at', '>=', Carbon::parse($date));
    }

    public static function buildIndexQuery($query)
    {
        $threadsQuery = QueryBuilder::for($query)
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

        $sortQuery = request()->query('sort');
        if (Str::contains($sortQuery, 'views')) {
            $sort = Str::startsWith($sortQuery, '-') ? 'sortByDesc' : 'sortBy';
            $threadsQuery = $threadsQuery->get()->$sort('views_count');
        }

        return $threadsQuery->paginate(12)->appends(request()->query());
    }

    public function getLinkAttribute()
    {
        return $this->getLink();
    }

    public function getLink(): string
    {
        return route('threads.show', [$this->channel, $this]);
    }

    public function bestReply()
    {
        return $this->replies()->where('id', $this->best_reply_id);
    }

    public function setSlugAttribute($value)
    {
        $slug = slugify("{$value}_" . now()->format('Y-m-d H:i'));

        $this->attributes['slug'] = $slug;
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);
        $lastView = Cache::get($key);

        return isset($lastView) && $this->updated_at > $lastView;
    }
}
