<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'level'];

    public function awardTo(User $user)
    {
        $this->users()->attach($user);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements');
    }
}
