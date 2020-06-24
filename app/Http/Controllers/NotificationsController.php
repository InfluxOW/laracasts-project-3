<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        $this->authorize('manageNotifications', $user);

        return $user->unreadNotifications;
    }

    public function destroy(User $user, DatabaseNotification $notification)
    {
        $this->authorize('manageNotifications', $user);
        $notification->markAsRead();
    }
}
