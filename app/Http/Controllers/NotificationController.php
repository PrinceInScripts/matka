<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)->latest()->limit(30)->get();
        return response()->json($notifications);
    }

    public function count()
    {
        $count = Notification::where('user_id', Auth::id())->where('is_read', 0)->count();
        return response()->json(['count' => $count]);
    }

    public function markRead(Request $request)
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => 1]);
        return response()->json(['status' => 'success']);
    }

    public function page()
    {
        return view('pages.notifications.index');
    }
}
