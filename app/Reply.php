<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;

class Reply extends Model
{
    use Favoriteable;
    use LogsActivity;

    protected $fillable = ['body', 'thread_id', 'user_id', 'created_at'];
    protected $with = ['user', 'favorites', 'thread.channel'];
    protected $withCount = ['favorites'];
    protected $touches = ['thread'];
    protected $appends = ['isFavorited'];
    // logs
    protected static $logAttributes = ['body'];
    protected static $logName = 'replies_log';
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

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

    public function getLink(): string
    {
//    $commentableResourceName = str_plural(strtolower(class_basename($comment->commentable_type)));
        $threadUrl = route('threads.show', [$this->thread->channel, $this->thread]);
        $replyUrl = "{$threadUrl}#reply-{$this->id}";
        return $replyUrl;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavoritedBy(Auth::user());
    }
}
