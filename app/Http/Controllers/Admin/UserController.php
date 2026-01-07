<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     public function index()
    {
        // search, filter, paginate users with Eloquent using User model and also search on wallet table for search id of user to get users balance
      /*
        $users1 = User::with('wallet')
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhereHas('wallet', function ($q2) use ($search) {
                          $q2->where('balance', 'like', "%$search%");
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        */

        // Get all users and balanace 
        $users=User::with('wallet')->orderBy('created_at', 'desc')->get();

        $users->map(function($user){
            $user->balance = $user->wallet ? $user->wallet->balance : 0;
            return $user;
        });

         
       
        return view('admin.user_management',compact('users'));
    }

    public function view($id)
    {
        $user = User::with('wallet')->findOrFail($id);
        $user->balance = $user->wallet ? $user->wallet->balance : 0;

        // return $user;
        return view('admin.user_view',compact('user'));
    }

    
}
