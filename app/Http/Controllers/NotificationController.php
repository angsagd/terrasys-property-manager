<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $this->authorize('view_notification');

        return view('notifications.index', [
            'notifications' => Notification::query()->latest()->paginate(20),
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('manage_notification');

        $notification->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}
