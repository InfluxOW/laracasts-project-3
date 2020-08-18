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
        ]);
    }

    public function modelKey()
    {
        return $this->model->getKey();
    }

    abstract public function qualifier(User $user): bool;
}
