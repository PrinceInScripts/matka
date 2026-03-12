<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UserQueryController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('user_queries')) {
            $queries = collect();
            $openCount = $inProgressCount = $resolvedCount = $closedCount = 0;
        } else {
            $queries         = UserQuery::with('user')->orderBy('created_at','desc')->get();
            $openCount       = $queries->where('status','open')->count();
            $inProgressCount = $queries->where('status','in_progress')->count();
            $resolvedCount   = $queries->where('status','resolved')->count();
            $closedCount     = $queries->where('status','closed')->count();
        }
        return view('admin.user_query', compact('queries','openCount','inProgressCount','resolvedCount','closedCount'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:user_queries,id',
            'admin_reply' => 'required|string|max:2000',
            'status'      => 'required|in:open,in_progress,resolved,closed',
        ]);

        $query = UserQuery::findOrFail($request->id);
        $query->update([
            'admin_reply' => $request->admin_reply,
            'status'      => $request->status,
            'admin_id'    => Auth::guard('admin')->id(),
            'replied_at'  => now(),
        ]);

        return response()->json(['status' => true, 'message' => 'Reply sent successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:open,in_progress,resolved,closed']);
        UserQuery::findOrFail($id)->update(['status' => $request->status]);
        return response()->json(['status' => true]);
    }

    public function destroy($id)
    {
        UserQuery::findOrFail($id)->delete();
        return response()->json(['status' => true]);
    }
}
