<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\GameList;
use App\Models\WalletTransactions;
use Illuminate\Support\Facades\Auth;
use App\Constants\GameTypes;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   function calculateAnk(int $gameType, string $number, string $session): int
{
    // 1️⃣ Single Digit
    if ($gameType === GameTypes::SINGLE_DIGIT) {
        return (int) $number;
    }

    // 2️⃣ Jodi Digit
    if ($gameType === GameTypes::JODI_DIGIT) {
        if (strlen($number) !== 2 || !ctype_digit($number)) {
            throw new Exception("Invalid jodi number: $number");
        }

        return $session === 'open'
            ? (int) $number[0]
            : (int) $number[1];
    }

    // 3️⃣ Panna (single / double / triple)
    if (in_array($gameType, GameTypes::PANNA_TYPES, true)) {
        if (!ctype_digit($number)) {
            throw new Exception("Invalid panna number: $number");
        }

        return array_sum(str_split($number)) % 10;
    }

    // 4️⃣ Half Sangam (panna-digit or digit-panna)
    if ($gameType === GameTypes::HALF_SANGAM) {
        if (!str_contains($number, '-')) {
            throw new Exception("Invalid half sangam: $number");
        }

        [$left, $right] = explode('-', $number);

        $target = $session === 'open' ? $left : $right;

        return ctype_digit($target)
            ? array_sum(str_split($target)) % 10
            : (int) $target;
    }

    // 5️⃣ Full Sangam (panna-panna)
    if ($gameType === GameTypes::FULL_SANGAM) {
        if (!str_contains($number, '-')) {
            throw new Exception("Invalid full sangam: $number");
        }

        [$openPanna, $closePanna] = explode('-', $number);

        $target = $session === 'open' ? $openPanna : $closePanna;

        if (!ctype_digit($target)) {
            throw new Exception("Invalid sangam panna: $number");
        }

        return array_sum(str_split($target)) % 10;
    }

    throw new Exception("Unsupported game type ID: $gameType");
}

    public function index()
    {
        $totalUsers = User::count();
        $approvedUsers = User::where('status', 1)->count();
        $pendingUsers = User::where('status', 0)->count();
        // take login user details
                $loggedInAdmin = Auth::guard('admin')->user();

        $totalGames= GameList::count();

         $last24HourBidAmount = WalletTransactions::where('type', 'debit')
        ->where('source', 'bid')
        ->where('created_at', '>=', now()->subDay())
        ->sum('amount');

        $today = strtolower(now()->format('l')); // e.g., 'monday', 'tuesday', etc.

        // return $today;

         $games = GameList::where('game_status', 1)
        ->where('market_status', 1)
        ->where('market_type', 'main')
        ->get()
        ->map(function ($game) use ($today) {

            // Today schedule
            $schedule = DB::table('market_schedules')
                ->where('market_id', $game->id)
                ->where('weekday', $today)
                ->first();

            if (!$schedule || !$schedule->is_open) {
                $game->today_open_time  = null;
                $game->today_close_time = null;
                $game->today_bid_amount = 0;
                return $game;
            }

            $open  = now()->setTimeFromTimeString($schedule->open_time);
            $close = now()->setTimeFromTimeString($schedule->close_time);

            // Handle night market crossing midnight
            if ($close->lt($open)) {
                $close->addDay();
            }

            // Sum bids ONLY for this market in this window
            $bidAmount = WalletTransactions::where('type', 'debit')
                ->where('source', 'bid')
                ->where('market_id', $game->id)
                ->whereBetween('created_at', [$open, $close])
                ->sum('amount');

            $game->today_open_time  = $schedule->open_time;
            $game->today_close_time = $schedule->close_time;
            $game->today_bid_amount = $bidAmount;

            return $game;
        });

        // return $games[0];
    //      $defaultMarket = $games->first();
    // $defaultSession = 'open';

     $defaultMarket = $games->first();
    $defaultSession = 'open';

    $ankData = collect();

    if ($defaultMarket) {
        $ankData = Bid::selectRaw('ank, COUNT(*) as total_bids, SUM(amount) as total_amount')
            ->where('market_id', $defaultMarket->id)
            ->whereRaw('LOWER(session) = ?', [$defaultSession])
            // ->whereDate('created_at', now())
            ->groupBy('ank')
            ->get()
            ->keyBy('ank');
    }

    // return $totalUsers.$approvedUsers.''.$pendingUsers.''.$loggedInAdmin.''.$totalGames.''.$last24HourBidAmount.''.$games.''.$defaultMarket.''.$defaultSession.''.$ankData it on array

    return response()->json([
        'totalUsers' => $totalUsers,
        'approvedUsers' => $approvedUsers,
        'pendingUsers' => $pendingUsers,
        'loggedInAdmin' => $loggedInAdmin,
        'totalGames' => $totalGames,
        'last24HourBidAmount' => $last24HourBidAmount,
        'games' => $games,
        'defaultMarket' => $defaultMarket,
        'defaultSession' => $defaultSession,
        'ankData' => $ankData,
    ]);

        return view('admin.dashboard', compact('totalUsers', 'approvedUsers', 'pendingUsers', 'loggedInAdmin', 'totalGames', 'last24HourBidAmount', 'games', 'defaultMarket', 'defaultSession', 'ankData'));
    }

    public function userManagement()
    {
        $users = User::all();
        return view('admin.user_management', compact('users'));
    }

    public function declareResult()
    {
        return view('admin.declare_result');
    }

    public function winningPredictions()
    {
        return view('admin.winning_predictions');
    }
}

