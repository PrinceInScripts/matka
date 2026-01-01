<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameNumberController extends Controller
{
    public function single_digit()
    {
        return view('admin.game_numbers.single_digit');
    }
    public function jodi_digit()
    {
        return view('admin.game_numbers.jodi_digit');
    }

    public function single_pana()
    {
        return view('admin.game_numbers.single_pana');
    }

    public function double_pana()
    {
        return view('admin.game_numbers.double_pana');
    }

    public function triple_pana()
    {
        return view('admin.game_numbers.triple_pana');
    }

    public function half_sangam()
    {
        return view('admin.game_numbers.half_sangam');
    }

    public function full_sangam()
    {
        return view('admin.game_numbers.full_sangam');
    }
    
}
