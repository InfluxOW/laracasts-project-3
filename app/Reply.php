<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Reply extends Model
{
    use Favoriteable;

    protected $fillable = ['body', 'thread_id', 'user_id', 'created_at'];
    protected $with = ['user', 'favorites'];
    protected $withCount = ['favorites'];
    protected $touches = ['thread'];

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
