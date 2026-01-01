<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FundController extends Controller
{
    public function allFunds()
    {
        return view('pages.funds.all-funds');
    }

    public function wallet()
    {
        return view('pages.funds.wallet');
    }

    public function depositFundsAuto()
    {
        return view('pages.funds.add_funds_auto');
    }

    public function depositFundsManual()
    {
        return view('pages.funds.add_funds_manual');
    }

    public function withdrawFunds()
    {
        return view('pages.funds.withdraw');
    }

    public function addBank()
    {
        return view('pages.funds.add_bank_details');
    }

    public function depositHistory()
    {
        return view('pages.funds.deposit_history');
    }

    public function withdrawHistory()
    {
        return view('pages.funds.withdraw_history');
    }


}
