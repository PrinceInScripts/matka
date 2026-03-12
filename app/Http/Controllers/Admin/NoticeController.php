<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('admin.notice.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'message'    => 'required|string|max:2000',
            'is_active'  => 'nullable|boolean',
            'start_time' => 'nullable|date',
            'end_time'   => 'nullable|date',
        ]);
        Announcement::create([
            'title'      => $request->title,
            'message'    => $request->message,
            'is_active'  => $request->is_active ?? 1,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);
        return response()->json(['status' => true, 'message' => 'Announcement created']);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'message' => 'required|string|max:2000']);
        $ann = Announcement::findOrFail($id);
        $ann->update([
            'title'     => $request->title,
            'message'   => $request->message,
            'is_active' => $request->has('is_active') ? $request->is_active : $ann->is_active,
        ]);
        return response()->json(['status' => true, 'message' => 'Updated successfully']);
    }

    public function toggleActive($id)
    {
        $ann = Announcement::findOrFail($id);
        $ann->update(['is_active' => !$ann->is_active]);
        return response()->json(['status' => true, 'is_active' => $ann->is_active]);
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Deleted']);
    }

    public function send()
    {
        $users = User::where('status', 1)->orderBy('name')->get(['id','name','phone']);
        return view('admin.notice.send', compact('users'));
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'message'  => 'required|string|max:1000',
            'target'   => 'required|in:all,specific',
            'user_ids' => 'required_if:target,specific|array',
        ]);

        $userIds = $request->target === 'all'
            ? User::where('status', 1)->pluck('id')
            : collect($request->user_ids);

        foreach ($userIds as $uid) {
            Notification::create([
                'user_id' => $uid,
                'title'   => $request->title,
                'message' => $request->message,
                'type'    => 'notice',
                'is_read' => 0,
            ]);
        }
        return response()->json(['status' => true, 'message' => 'Notification sent to ' . $userIds->count() . ' users']);
    }
}
