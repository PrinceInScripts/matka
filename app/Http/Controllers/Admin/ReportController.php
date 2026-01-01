<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function user_bid_history()
    {
        return view('admin.reports.user_bid');
    }

    public function customer_sell_report()
    {
        return view('admin.reports.customer_sell');
    }

    public function winning()
    {
        return view('admin.reports.winning');
    }

    public function transfer_point()
    {
        return view('admin.reports.transfer_point');
    }

    public function bid_win()
    {
        return view('admin.reports.bid_win');
    }

    public function withdraw()
    {
        return view('admin.reports.withdraw');
    }

    public function referral()
    {
        return view('admin.reports.referral');
    }

    public function deposit()
    {
        return view('admin.reports.deposit');
    }
}
