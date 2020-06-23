<?php

namespace App;

use App\Traits\Subscriber;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password', 'username'
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

    //

    public function getAvatarAttribute()
    {
        return $this->getAvatar();
    }

    public function getAvatar()
    {
        return $this->avatar->url ?? $this->avatar_url ?? "https://api.adorable.io/avatars/200/abott@adorable{$this->username}";
    }

    public function getBanner()
    {
        return $this->banner->url ?? $this->banner_url ?? "https://picsum.photos/seed/{$this->username}/1836/500";
    }

    //
    public function isAdmin()
    {
        return $this->admin;
    }
}
