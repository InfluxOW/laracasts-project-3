<?php

namespace App\Achievements;

use App\Achievement;
use App\User;

abstract class AchievementType
{
    protected $model;

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'level' => $this->level()
        ]);
    }

    public function modelKey()
    {
        return $this->model->getKey();
    }

    public function level()
    {
        return 'intermediate';
    }

    abstract public function qualifier(User $user): bool;
}
