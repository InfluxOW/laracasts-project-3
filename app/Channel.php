<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'slug'];
    protected $withCount = ['threads'];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
