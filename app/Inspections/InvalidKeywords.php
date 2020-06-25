<?php

namespace App\Inspections;

use Dotenv\Exception\ValidationException;

class InvalidKeywords
{
    /**
     * All spam keywords
     *
     * @var array
     */
    protected $keywords = [
        'customer support',
    ];

    /**
     * Detect spam
     *
     * @param  string $text
     * @throws \ValidationException
     */
    public function detect($text)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                throw new ValidationException("Your input contains spam.");
            }
        }
    }

}
