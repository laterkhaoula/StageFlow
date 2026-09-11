<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->whereKey($notificationId)
            ->first();

        if (! $notification) {
            abort(403, 'Cette notification ne vous appartient pas.');
        }

        $notification->markAsRead();

        return redirect()->route('notifications.index')->with('success', 'Notification marquée comme lue.');
    }
}
