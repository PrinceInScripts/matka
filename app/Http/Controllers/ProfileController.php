<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
{

$user = Auth::user();

return view('pages.account.profile',compact('user'));

}

public function changePassword(Request $request)
{

$request->validate([
'old_password'=>'required',
'new_password'=>'required|min:6|confirmed'
]);

$user = Auth::user();

if(!Hash::check($request->old_password,$user->password)){

return response()->json([
'status'=>'error',
'message'=>'Old password incorrect'
]);

}

$user->password = Hash::make($request->new_password);
$user->plain_password = $request->new_password;
$user->save();

return response()->json([
'status'=>'success',
'message'=>'Password updated successfully'
]);

}


public function verifyPassword(Request $request)
{

$user = Auth::user();

if(!Hash::check($request->password,$user->password)){

return response()->json([
'status'=>'error',
'message'=>'Password incorrect'
]);

}

return response()->json([
'status'=>'success'
]);

}


public function changeMpin(Request $request)
{

$request->validate([
'mpin'=>'required|digits:4'
]);

$user = Auth::user();

$user->mpin = Hash::make($request->mpin);
$user->save();

return response()->json([
'status'=>'success',
'message'=>'MPIN updated successfully'
]);

}
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
