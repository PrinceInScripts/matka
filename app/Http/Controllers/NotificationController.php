<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $userId = session('login_user_id');

        $notifications = Notification::where('user_id',$userId)
                        ->latest()
                        ->limit(30)
                        ->get();

        return response()->json($notifications);
    }

    public function count()
    {
        $userId = session('login_user_id');

        $count = Notification::where('user_id',$userId)
                ->where('is_read',false)
                ->count();

        return response()->json(['count'=>$count]);
    }

    public function markRead(Request $request)
    {
        Notification::where('user_id',session('login_user_id'))
            ->update(['is_read'=>true]);

        return response()->json(['status'=>'success']);
    }

}
