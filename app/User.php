<?php

namespace App;

use App\Traits\Subscriber;
use CyrildeWit\EloquentViewable\View;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
    use Favoriter;
    use CausesActivity;
    use LogsActivity;
    use Subscriber;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'created_at', 'updated_at', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $withCount = ['threads', 'replies'];
    protected $appends = ['avatar'];
    // logs
    protected static $logAttributes = ['name', 'username', 'email'];
    protected static $logName = 'users_log';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $recordEvents = ['created', 'updated', 'deleted'];

    //Relations

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    //

    public function getAvatarAttribute()
    {
        return $this->getAvatar();
    }

    public function getAvatar()
    {
        return $this->avatar_path ?? "https://api.adorable.io/avatars/200/{$this->username}";
    }

    public function getBanner()
    {
        return $this->banner->url ?? $this->banner_url ?? "https://picsum.photos/seed/{$this->username}/1836/500";
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public function visitedThreadCacheKey($thread)
    {
        return "user.{$this->id}.viewed.thread.{$thread->id}";
    }

    public function read($thread)
    {
        $view = views($thread)->record();
        $this->views()->save($view);
        $key = $this->visitedThreadCacheKey($thread);
        Cache::forever($key, $view->viewed_at);
    }

    public function canPost($latestPostData, $userPostsFrequency)
    {
        return $latestPostData->diffInSeconds() > $userPostsFrequency;
    }

    public function getLastPublicationDate()
    {
        $lastThreadDate = $this->threads_count > 0 ? $this->threads->last()->created_at : null;
        $lastReplyDate = $this->replies_count > 0 ? $lastReplyDate = $this->replies->last()->created_at : null;

        return max($lastReplyDate, $lastThreadDate);
    }
}
