<?php

namespace App;

use App\Traits\Subscribable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Stevebauman\Purify\Facades\Purify;

class Thread extends Model
{
    use Favoriteable;
    use LogsActivity;
    use Subscribable;
    use Searchable;

    protected $appends = ['views_count'];
    protected $fillable = ['body', 'title', 'channel_id', 'user_id', 'slug', 'created_at', 'best_reply_id', 'closed', 'pinned', 'image'];
    protected $with = ['channel', 'user', 'favorites'];
    protected $withCount = ['favorites', 'replies'];
    protected $casts = [
        'closed' => 'boolean',
        'pinned' => 'boolean'
    ];
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
        return $this->belongsTo(Channel::class)->withoutGlobalScope('active');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function bestReply()
    {
        return $this->hasOne(Reply::class, 'id', 'best_reply_id');
    }

    // Helpers

    public function getImage()
    {
        return $this->image ?? "https://picsum.photos/seed/{$this->slug}/720/400";
    }

    public function getRecomendationsAttribute()
    {
        $recomendationsAmount = min(3, $this->channel->threads_count - 1);
        return $this->channel->threads->where('id', '<>', $this->id)->random($recomendationsAmount);
    }

    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
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

    public function scopeFavoritedByUser(Builder $query, $userSlug): Builder
    {
        $user = User::firstOrFail($userSlug);
        return $query->whereHas('favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public static function buildIndexQuery($query)
    {
        $threadsQuery = QueryBuilder::for($query)
            ->allowedFilters([
                'user.username',
                AllowedFilter::scope('created_after'),
                AllowedFilter::scope('favorited_by_user'),
            ])
            ->allowedSorts([
                AllowedSort::field('views', 'views_count'),
                AllowedSort::field('replies', 'replies_count'),
                AllowedSort::field('favorites', 'favorites_count'),
            ])
            ->orderBy('pinned', 'DESC')
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
        return route('threads.show', [$this->channel, $this], false);
    }

    public function setSlugAttribute($value)
    {
        $slug = slugify("{$value}_" . $this->created_at->format('Y-m-d H:i'));

        $this->attributes['slug'] = $slug;
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);
        $lastView = Cache::get($key);

        return isset($lastView) && $this->updated_at > $lastView;
    }

    public function close()
    {
        $this->update(['closed' => true]);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'views_count' => $this->views_count,
            'replies_count' => $this->replies_count,
            'favorites_count' => $this->favorites_count,
            'link' => $this->link,
            'channel.id' => $this->channel->id,
            'channel.name' => $this->channel->name
        ];
    }
}
