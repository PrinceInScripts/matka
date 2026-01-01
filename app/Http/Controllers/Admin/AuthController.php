<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

//         if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
//     return redirect()->route('admin.dashboard');
// }

// return back()->withErrors(['email' => 'Invalid admin credentials']);


        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'redirect' => route('admin.login'),
            'message' => 'Invalid credentials'
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
