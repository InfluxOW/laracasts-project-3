<?php

namespace App;

use App\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Thread extends Model implements Viewable
{
    use InteractsWithViews;

    protected $fillable = ['body', 'title', 'channel_id', 'user_id'];
    protected $with = ['channel', 'user'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::addGlobalScope('viewsCount', function ($builder) {
            $builder->withCount('views');
        });
    }

    //Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    //

    public function addReply($reply)
    {
        $reply = Auth::user()->replies()->make($reply);
        $this->replies()->save($reply);
    }

    public function getImage()
    {
        return $this->image->url ?? "https://picsum.photos/seed/{$this->title}/720/400";
    }
}
