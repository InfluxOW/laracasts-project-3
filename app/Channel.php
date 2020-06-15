<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Channel extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'slug'];
    // logs
    protected static $logAttributes = ['name'];
    protected static $logName = 'channels_log';
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Channel '{$this->name}' has been {$eventName}";
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
