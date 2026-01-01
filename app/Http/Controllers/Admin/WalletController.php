<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function fund_request()
    {
        return view('admin.wallet.fund_request');
    }

    public function withdraw_request()
    {
        return view('admin.wallet.withdraw_request');
    }

    public function add_fund()
    {
        return view('admin.wallet.add_fund');
    }

    public function bid_report()
    {
        return view('admin.wallet.bid_report');
    }
}

