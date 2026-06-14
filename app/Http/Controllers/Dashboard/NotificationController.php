<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status', 'all');

        $query = $user->notifications();

        if ($status === 'unread') {
            $query = $user->unreadNotifications();
        }

        return view('dashboard.notifications', [
            'notifications' => $query->paginate(10)->withQueryString(),
            'status' => $status,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('dashboard.notifications.index');
    }
      public function read(string $id)
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications()->findOrFail($id);

        $notification->markAsRead();

        return redirect()->route('dashboard.notifications.index');
    }

    public function unread(string $id)
    {
        $user = Auth::user();
        $notification = $user->readNotifications()->findOrFail($id);

        $notification->markAsUnread();

        return redirect()->route('dashboard.notifications.index');
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        $notification->delete();

        return redirect()->route('dashboard.notifications.index');
    }
}