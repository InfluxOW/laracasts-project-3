<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
