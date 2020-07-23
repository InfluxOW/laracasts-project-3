<?php

namespace App;

use App\Events\BestReplyCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;
use Stevebauman\Purify\Facades\Purify;

class Reply extends Model
{
    use Favoriteable;
    use LogsActivity;

    protected static $logAttributes = ['body'];
    protected static $logName = 'replies_log';
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $recordEvents = ['created', 'updated'];
    // logs
    protected $fillable = ['body', 'thread_id', 'user_id', 'created_at', 'parent_id'];
    protected $with = ['user', 'favorites', 'thread.channel', 'parent'];
    protected $withCount = ['favorites'];
    protected $touches = ['thread'];
    protected $appends = ['link', 'isFavorited', 'isBest', 'hasParent'];

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    //Helpers

    public function getLinkAttribute()
    {
        $threadUrl = route('threads.show', [$this->thread->channel, $this->thread], false);
        $repliesPerPage = 15;
        $replyPosition = $this->thread->replies()->pluck('id')->search($this->id) + 1;
        $page = $page = ceil($replyPosition / $repliesPerPage);
        return "{$threadUrl}?page={$page}#reply-{$this->id}";
    }

    public function getIsFavoritedAttribute()
    {
        return Auth::check() && $this->isFavoritedBy(Auth::user());
    }

    public function mentionedUsers()
    {
        preg_match_all("/\B\@([\w\-]+)/", $this->body, $matches);
        return $matches[1];
    }

    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            "/\B\@([\w\-]+)/",
            '<a href="/profiles/$1" class="text-blue-500 hover:text-opacity-75">$0</a>',
            $body
        );
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function markAsBest()
    {
        event(new BestReplyCreated($this));
        $this->thread->update(['best_reply_id' => $this->id]);
    }

    public function replies()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function getHasParentAttribute()
    {
        return $this->hasParent();
    }

    public function hasParent()
    {
        return isset($this->parent);
    }
}
