<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Spatie\Activitylog\Traits\LogsActivity;

class Reply extends Model
{
    use Favoriteable;
    use LogsActivity;


    protected $fillable = ['body', 'thread_id', 'user_id', 'created_at'];
    protected $with = ['user', 'favorites'];
    protected $withCount = ['favorites'];
    protected $touches = ['thread'];
    // logs
    protected static $logAttributes = ['body'];
    protected static $logName = 'replies_log';
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Reply '{$this->body}' has been {$eventName}";
    }

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
