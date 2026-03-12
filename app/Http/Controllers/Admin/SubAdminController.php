<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SubAdminController extends Controller
{
    public function index()
    {
        $subAdmins = Schema::hasTable('sub_admins')
            ? SubAdmin::orderBy('created_at','desc')->get()
            : collect();
        return view('admin.subadmin.index', compact('subAdmins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:sub_admins,username',
            'password' => 'required|string|min:6',
            'status'   => 'nullable|in:0,1',
        ]);

        SubAdmin::create([
            'name'        => $request->name,
            'username'    => $request->username,
            'phone'       => $request->phone,
            'password'    => Hash::make($request->password),
            'status'      => $request->status ?? 1,
            'permissions' => $request->permissions ?? [],
        ]);

        return response()->json(['status' => true, 'message' => 'Sub-admin created successfully']);
    }

    public function update(Request $request, $id)
    {
        $sa = SubAdmin::findOrFail($id);
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'nullable|in:0,1',
        ]);

        $data = [
            'name'        => $request->name,
            'phone'       => $request->phone,
            'status'      => $request->status ?? 1,
            'permissions' => $request->permissions ?? [],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $sa->update($data);
        return response()->json(['status' => true, 'message' => 'Sub-admin updated']);
    }

    public function toggle($id)
    {
        $sa = SubAdmin::findOrFail($id);
        $sa->update(['status' => !$sa->status]);
        return response()->json(['status' => true, 'active' => $sa->status]);
    }

    public function destroy($id)
    {
        SubAdmin::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Sub-admin deleted']);
    }
}
