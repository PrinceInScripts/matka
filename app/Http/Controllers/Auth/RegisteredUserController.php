<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
 {
    /**
    * Display the registration view.
    */

    public function create(): View
 {
        return view( 'auth.register' );
    }

    /**
    * Handle an incoming registration request.
    *
    * @throws \Illuminate\Validation\ValidationException
    */

    public function store( Request $request )
 {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255' ],
            'email' => [ 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class ],
        ] );

        $phone = $request->session()->get( 'phone_number' );

        if ( !$phone ) {
            return response()->json( [
                'status' => 'error',
                'redirect' => route( 'register' ),
                'message' => 'Phone number is missing. Please enter your phone number again.'
            ] );
        }

        $user = User::create( [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phone,
        ] );

        event( new Registered( $user ) );

        $request->session()->put( 'login_user_id', $user->id );

        return response()->json( [
            'status' => 'success',
            'redirect' => route( 'set.mpin' ),
            'message' => 'Registration successful. Please set your MPIN.'
        ] );
    }

    public function createMpin(): View
 {
        return view( 'auth.set-mpin' );
    }

    public function storeMpin( Request $request )
 {
        $request->validate( [
            'mpin' => 'required|digits:4', // assuming 4-digit MPIN
        ] );

        $userId = $request->session()->get( 'login_user_id' );
        $user = User::find( $userId );

        if ( !$user ) {
            return response()->json( [
                'status' => 'error',
                'message' => 'User not found. Please login again.',
                'redirect' => route( 'login' )
            ] );
        }

        $user->mpin = Hash::make( $request->mpin );
        $user->save();

        // Login user
        Auth::login( $user );
        $request->session()->regenerate();

        Auth::login( $user );
        $request->session()->regenerate();
        $request->session()->forget( 'login_user_id' );

        return response()->json( [
            'status' => 'success',
            'message' => 'MPIN set successfully!',
            'redirect' => route( 'home' )
        ] );
    }

}
