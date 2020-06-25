<?php

namespace App\Inspections;

use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;

class PostedTooOften
{
    /**
     * Detect spam
     *
     * @param  string $text
     * @throws \ValidationException
     */
    public function detect($text)
    {
        $user = Auth::user();
        $latestPostData = $user->getLastPublicationDate();

        if ($latestPostData) {
            $userPostsFrequency = config('app.spam_detection.user_can_post_once_in');
            if (! $user->canPost($latestPostData, $userPostsFrequency)) {
                throw new ValidationException("You can post only once in {$userPostsFrequency} seconds.");
            }
        }
    }
}
