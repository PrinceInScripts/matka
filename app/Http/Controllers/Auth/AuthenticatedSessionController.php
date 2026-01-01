<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
{
    $request->validate([
        'mobile' => 'required|digits_between:10,15',
    ]);

    $user = User::where('phone', $request->mobile)->first();


    if (!$user) {
        $request->session()->put('phone_number', $request->mobile);

        return response()->json([
            'status' => 'success',
            'redirect' => route('register'),
            'message' => 'User not found. Please register first.'
        ]);
    }

    if(!$user->mpin){
        $request->session()->put('login_user_id', $user->id);

        return response()->json([
            'status' => 'error',
            'redirect' => route('create.mpin'),
            'message' => 'MPIN not set. Please create your MPIN first.'
        ]);
    }

    $request->session()->put('login_user_id', $user->id);

    return response()->json([
        'status' => 'success',
        'redirect' => route('login.mpin'),
        'message' => 'User found! Redirecting to MPIN login...'
    ]);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function loginMpin()
    {
        if (!session()->has('login_user_id')) {
            return redirect()->route('login')->with('error', 'Please enter your mobile number first.');
        }

        return view('auth.login-mpin');
    }


    public function authenticateMpin(Request $request)
    {
        $request->validate([
            'mpin' => 'required|digits:4',
        ]);

        $userId = $request->session()->get('login_user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found. Please login again.',
                'redirect' => route('login')
            ]);
        }

        if (!Hash::check($request->mpin, $user->mpin)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid MPIN. Please try again.'
            ]);
        }

        // Login user
        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'status' => 'success',
            'redirect' => route('home'),
            'message' => 'Login successful!'
        ]);
    }

    
}
