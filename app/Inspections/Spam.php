<?php

namespace App\Inspections;

class Spam
{
    /**
     * All registered inspections
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * Detect spam
     *
     * @param  string $text
     * @return bool
     */
    public function detect($text)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($text);
        }

        return false;
    }
}
