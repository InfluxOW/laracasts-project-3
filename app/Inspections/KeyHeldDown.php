<?php

namespace App\Inspections;

use Dotenv\Exception\ValidationException;

class KeyHeldDown
{
    /**
     * Detect spam
     *
     * @param  string $text
     * @throws \ValidationException
     */
    public function detect($text)
    {
        if (preg_match('/[^\s](.)\\1{4,}/', $text)) {
            throw new ValidationException("Your input contains spam.");
        }
    }
}
