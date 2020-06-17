<?php

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function getFlashMessageStyles($level)
{
    switch ($level) {
        case 'error':
            return 'bg-red-100  border-red-400 text-red-700';
        case 'success':
            return 'bg-green-100  border-green-400 text-green-700';
        case 'info':
            return 'bg-blue-100  border-blue-400 text-blue-700';
        case 'warning':
            return 'bg-yellow-100  border-yellow-400 text-yellow-700';
        default:
            return 'bg-gray-100  border-gray-400 text-gray-700';
    }
}
