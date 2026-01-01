<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\GameManagementController;
use App\Http\Controllers\Admin\GameNumberController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StarlineController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserQueryController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\GameLayoutController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('pages.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test',[PageController::class, 'test1'])->name('test');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/home', [PageController::class, 'home'])->name('home');
    Route::get('/starline', [PageController::class, 'starline'])->name('starline');
    Route::get('/galidisawar', [PageController::class, 'galidisawar'])->name('galidisawar');
Route::get('/market/{slug}', [PageController::class, 'play'])->name('play');
Route::get('/starline/{slug}', [PageController::class, 'starlineGame'])->name('starline.play');
Route::get('/category/{slug}', [PageController::class, 'category'])->name('category');
Route::get('/single', [PageController::class, 'single'])->name('single');
Route::get('/bulk', [PageController::class, 'bulk'])->name('bulk');
Route::get('half-sangam', [PageController::class, 'halfSangam'])->name('half.sangam');
Route::get('full-sangam', [PageController::class, 'fullSangam'])->name('full.sangam');

Route::get('/{game_type}/{market}/game/{code}', [GameLayoutController::class, 'getGameLayout']);

Route::get('/account-statement', [PageController::class, 'accountStatement'])->name('account.statement');
Route::get('/game-rates', [PageController::class, 'gameRates'])->name('game.rates');
Route::get('/all-funds', [FundController::class, 'allFunds'])->name('all.funds');

Route::get('/all-bids', [BidController::class, 'allBids'])->name('all.bids');
Route::get('/my-bids', [BidController::class, 'myBids'])->name('my.bids');
Route::get('/request-fund', [BidController::class, 'requestFund'])->name('request.fund');
Route::get('/approved-credit', [BidController::class, 'approvedCredit'])->name('approved.credit');
Route::get('/approved-debit', [BidController::class, 'approvedDebit'])->name('approved.debit');


Route::get('/wallet',[FundController::class, 'wallet'])->name('wallet');
Route::get('deposit-funds-auto',[FundController::class, 'depositFundsAuto'])->name('deposit.funds.auto');
Route::get('deposit-funds-manual',[FundController::class, 'depositFundsManual'])->name('deposit.funds.manual');
Route::get('withdraw-funds',[FundController::class, 'withdrawFunds'])->name('withdraw.funds');
Route::get('add-bank',[FundController::class, 'addBank'])->name('add.bank');
Route::get('deposit-history',[FundController::class, 'depositHistory'])->name('deposit.history');
Route::get('withdraw-history',[FundController::class, 'withdrawHistory'])->name('withdraw.history');

Route::post('/place-bid', [BidController::class, 'placeBid'])->name('place.bids');

});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
     Route::middleware('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
         // User Management
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('user/{id}', [UserController::class, 'view'])->name('user.view');

        // Declare Result
        Route::get('declare-result', [DashboardController::class, 'declareResult'])->name('declare_result');

        // Winning Predictions
        Route::get('winning-predictions', [DashboardController::class, 'winningPredictions'])->name('winning_predictions');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('user-bid-history', [ReportController::class, 'user_bid_history'])->name('user_bid_history');
            Route::get('customer-sell', [ReportController::class, 'customer_sell'])->name('customer_sell');
            Route::get('winning', [ReportController::class, 'winning'])->name('winning');
            Route::get('transfer-point', [ReportController::class, 'transfer_point'])->name('transfer_point');
            Route::get('bid-win', [ReportController::class, 'bid_win'])->name('bid_win');
            Route::get('withdraw', [ReportController::class, 'withdraw'])->name('withdraw');
            Route::get('referral', [ReportController::class, 'referral'])->name('referral');
            Route::get('deposit', [ReportController::class, 'deposit'])->name('deposit');
        });

         // Wallet Management
        Route::prefix('wallet')->name('wallet.')->group(function () {
            Route::get('fund-request', [WalletController::class, 'fund_request'])->name('fund_request');
            Route::get('withdraw-request', [WalletController::class, 'withdraw_request'])->name('withdraw_request');
            Route::get('add-fund', [WalletController::class, 'add_fund'])->name('add_fund');
            Route::get('bid-report', [WalletController::class, 'bid_report'])->name('bid_report');
        });

        // Notice Management
        Route::prefix('notice')->name('notice.')->group(function () {
            Route::get('manage', [NoticeController::class, 'index'])->name('manage');
            Route::get('send', [NoticeController::class, 'send'])->name('send');
        });

        // Game Management
        Route::prefix('games')->name('games.')->group(function () {
            Route::get('names', [GameController::class, 'names'])->name('names');
            Route::get('rates', [GameController::class, 'rates'])->name('rates');
                        Route::post('{id}/update-names', [GameController::class, 'updateNames'])->name('update-names');

            Route::post('rates/update', [GameController::class, 'updateRates'])->name('rates.update');
            Route::post('store', [GameController::class, 'store'])->name('store');
            Route::post('schedule/{id}', [GameController::class, 'update_schedule'])->name('update_schedule');
            Route::get('/get-schedule/{id}', [GameController::class, 'getSchedule'])->name('get_schedule');

            Route::get('/game-types/{id}', [GameController::class, 'getGameTypes'])->name('game-types');

            Route::post('/game-types/{id}', [GameController::class, 'updateGameTypes'])->name('game-types.update');


        });
 

        // Game & Numbers
        Route::prefix('game_numbers')->name('game_numbers.')->group(function () {
            Route::get('single-digit', [GameNumberController::class, 'single_digit'])->name('single_digit');
            Route::get('jodi-digit', [GameNumberController::class, 'jodi_digit'])->name('jodi_digit');
            Route::get('single-panna', [GameNumberController::class, 'single_panna'])->name('single_panna');
            Route::get('double-panna', [GameNumberController::class, 'double_panna'])->name('double_panna');
            Route::get('triple-panna', [GameNumberController::class, 'triple_panna'])->name('triple_panna');
            Route::get('half-sangam', [GameNumberController::class, 'half_sangam'])->name('half_sangam');
            Route::get('full-sangam', [GameNumberController::class, 'full_sangam'])->name('full_sangam');
        });

        // Starline
        Route::prefix('starline')->name('starline.')->group(function () {
            Route::get('game_name', [StarlineController::class, 'game_name'])->name('game_name');
              Route::get('rates', [StarlineController::class, 'rates'])->name('rates');
            Route::post('/rates/update', [StarlineController::class, 'update_rates'])->name('rates.update');
            
             Route::post('/store', [StarlineController::class, 'store'])->name('store');
             Route::post('/{id}/update', [StarlineController::class, 'update'])->name('update');
             Route::get('/{id}/schedule', [StarlineController::class, 'getSchedule'])->name('schedule.get');
             Route::post('/{id}/schedule', [StarlineController::class, 'updateSchedule'])->name('schedule.update');
        
          
            Route::get('bid-history', [StarlineController::class, 'bid_history'])->name('bid_history');
            Route::get('declare-result', [StarlineController::class, 'declare_result'])->name('declare_result');
            Route::get('result-history', [StarlineController::class, 'result_history'])->name('result_history');
            Route::get('sell-report', [StarlineController::class, 'sell_report'])->name('sell_report');
            Route::get('winning-report', [StarlineController::class, 'winning_report'])->name('winning_report');
            Route::get('winning-prediction', [StarlineController::class, 'winning_prediction'])->name('winning_prediction');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('main', [SettingController::class, 'main'])->name('main');
            Route::get('contact', [SettingController::class, 'contact'])->name('contact');
            Route::get('clear-data', [SettingController::class, 'clear_data'])->name('clear_data');
            Route::get('slider-images', [SettingController::class, 'slider_images'])->name('slider_images');
            Route::get('how-to-play', [SettingController::class, 'how_to_play'])->name('how_to_play');
        });

        // User Query Management
        Route::get('queries', [UserQueryController::class, 'index'])->name('queries.index');

        // Sub Admin Management
        Route::get('sub-admins', [SubAdminController::class, 'index'])->name('sub_admin.index');


         });
});

require __DIR__.'/auth.php';
