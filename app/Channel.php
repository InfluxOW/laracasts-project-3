<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'archived'];
    protected $withCount = ['threads'];
    protected $casts = [
        'archived' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function ($builder) {
            $builder->where('archived', false)
                ->orderBy('name', 'asc');
        });
    }

    //Relations

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    //

    public function archive()
    {
        $this->update(['archived' => true]);
    }
}
