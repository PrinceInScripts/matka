<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaliDisawarController;
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
use App\Http\Controllers\GaliDisaController;
use App\Http\Controllers\GameLayoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResultController;

Route::get('/', function () { return view('auth.login'); });
Route::get('/dashboard', function () { return view('pages.home'); })->middleware(['auth','verified'])->name('dashboard');
Route::get('/test', [PageController::class, 'test1'])->name('test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home', [PageController::class, 'home'])->name('home');
    Route::get('/starline', [PageController::class, 'starline'])->name('starline');
    Route::get('/market/{slug}', [PageController::class, 'play'])->name('play');
    Route::get('/starline/{slug}', [PageController::class, 'starlineGame'])->name('starline.play');
    Route::get('/category/{slug}', [PageController::class, 'category'])->name('category');
    Route::get('/single', [PageController::class, 'single'])->name('single');
    Route::get('/bulk', [PageController::class, 'bulk'])->name('bulk');
    Route::get('half-sangam', [PageController::class, 'halfSangam'])->name('half.sangam');
    Route::get('full-sangam', [PageController::class, 'fullSangam'])->name('full.sangam');
    Route::get('/gali_disawar/{slug}', [PageController::class, 'galiDisawarGame'])->name('galidisawar.game');
    Route::get('/galidisawar', [GaliDisaController::class, 'galiDisawar'])->name('galidisawar');
    Route::get('/{game_type}/{market}/game/{code}', [GameLayoutController::class, 'getGameLayout']);

    Route::get('/account-statement', [PageController::class, 'accountStatement'])->name('account.statement');
    Route::get('/game-rates', [PageController::class, 'gameRates'])->name('game.rates');

    // Bids
    Route::get('/all-funds', [FundController::class, 'allFunds'])->name('all.funds');
    Route::get('/all-bids', [BidController::class, 'allBids'])->name('all.bids');
    Route::get('/my-bids', [BidController::class, 'myBids'])->name('my.bids');
    Route::get('/request-fund', [BidController::class, 'requestFund'])->name('request.fund');
    Route::get('/approved-credit', [BidController::class, 'approvedCredit'])->name('approved.credit');
    Route::get('/approved-debit', [BidController::class, 'approvedDebit'])->name('approved.debit');
    Route::post('/place-bid', [BidController::class, 'placeBid'])->name('place.bids');

    // Starline bid/win history (user side)
    Route::get('/starline-bid-history', [BidController::class, 'starlineBidHistory'])->name('starline.bid.history');
    Route::get('/starline-win-history', [BidController::class, 'starlineWinHistory'])->name('starline.win.history');

    Route::get('/galidisawar-bid-history', [BidController::class, 'galidisawarBidHistory'])->name('galidisawar.bid.history');
    Route::get('/galidisawar-win-history', [BidController::class, 'galidisawarWinHistory'])->name('galidisawar.win.history');

    // Wallet & Funds
    Route::get('/wallet', [FundController::class, 'wallet'])->name('wallet');
    Route::get('deposit-funds', [FundController::class, 'depositFunds'])->name('deposit.funds');
    Route::get('deposit-funds-auto', [FundController::class, 'depositFundsAuto'])->name('deposit.funds.auto');
    Route::post('deposit-funds-auto', [FundController::class, 'depositFundsStore'])->name('deposit.funds.store');
    Route::get('deposit-funds-manual', [FundController::class, 'depositFundsManual'])->name('deposit.funds.manual');
    Route::post('deposit-funds-manual', [FundController::class, 'depositFundsManualStore'])->name('deposit.funds.manual.store');
    Route::get('withdraw-funds', [FundController::class, 'withdrawFunds'])->name('withdraw.funds');
    Route::post('withdraw-funds', [FundController::class, 'withdrawFundsStore'])->name('withdraw.funds.store');
    Route::get('add-bank', [FundController::class, 'addBank'])->name('add.bank');
    Route::get('deposit-history', [FundController::class, 'depositHistory'])->name('deposit.history');
    Route::get('withdraw-history', [FundController::class, 'withdrawHistory'])->name('withdraw.history');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/count', [NotificationController::class, 'count']);
    Route::post('/notifications/read', [NotificationController::class, 'markRead']);
    Route::get('/notifications/all', [NotificationController::class, 'page'])->name('notifications.page');

    // Chart
// Chart
    Route::get('/chart/{market_type}/{slug?}', [PageController::class, 'chart'])->name('chart');
    Route::get('/chart/starline', [PageController::class, 'chart'])->defaults('market_type','starline')->defaults('slug','all')->name('chart.starline');


    // Profile extras
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('/verify-password', [ProfileController::class, 'verifyPassword'])->name('verify.password');
    Route::post('/change-mpin', [ProfileController::class, 'changeMpin'])->name('change.mpin');

    Route::get('/support', [PageController::class, 'support'])->name('support');
    Route::get('/how-to-play', [PageController::class, 'howtoplay'])->name('how.to.play');
    Route::get('/terms-conditions', [PageController::class, 'termsconditions'])->name('terms.conditions');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('dashboard/ank', [DashboardController::class, 'ankData'])->name('dashboard.ank');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('user/{id}', [UserController::class, 'view'])->name('user.view');
        Route::post('user/{id}/toggle-betting', [UserController::class, 'toggleBetting'])->name('user.toggle_betting');
        Route::post('user/{id}/toggle-transfer', [UserController::class, 'toggleTransfer'])->name('user.toggle_transfer');
        Route::post('user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle_status');
        Route::post('user/{id}/add-balance', [UserController::class, 'addBalance'])->name('user.add_balance');
        Route::post('user/{id}/deduct-balance', [UserController::class, 'deductBalance'])->name('user.deduct_balance');

        // Game Management
        // Route::get('game-names', [GameManagementController::class, 'gameNames'])->name('game_names');
        // Route::get('game-management', [GameManagementController::class, 'index'])->name('game_management.index');
        // Route::post('game-management/store', [GameManagementController::class, 'store'])->name('game.store');
        // Route::post('game-management/{id}/update', [GameManagementController::class, 'update'])->name('game_management.update');
        // Route::get('game-management/{id}/schedule', [GameManagementController::class, 'getSchedule'])->name('game_management.schedule');
        // Route::post('game-management/{id}/schedule', [GameManagementController::class, 'updateSchedule'])->name('game_management.schedule.update');
        // Route::post('game-management/{id}/game-types', [GameManagementController::class, 'updateGameTypes'])->name('game_management.game_types');
        // Route::post('game-management/{id}/rates', [GameManagementController::class, 'updateRates'])->name('game_management.rates');

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
        // Game Numbers
        Route::prefix('game-numbers')->name('game_numbers.')->group(function () {
            Route::get('single-digit', [GameNumberController::class, 'singleDigit'])->name('single_digit');
            Route::get('jodi-digit', [GameNumberController::class, 'jodiDigit'])->name('jodi_digit');
            Route::get('single-panna', [GameNumberController::class, 'singlePanna'])->name('single_panna');
            Route::get('double-panna', [GameNumberController::class, 'doublePanna'])->name('double_panna');
            Route::get('triple-panna', [GameNumberController::class, 'triplePanna'])->name('triple_panna');
            Route::get('half-sangam', [GameNumberController::class, 'halfSangam'])->name('half_sangam');
            Route::get('full-sangam', [GameNumberController::class, 'fullSangam'])->name('full_sangam');
        });

        // Declare Result (main)
        Route::get('declare-result', [DashboardController::class, 'declareResult'])->name('declare_result');
        Route::get('winning-predictions', [DashboardController::class, 'winningPredictions'])->name('winning_predictions');

        // Reports
        Route::get('reports/bid-win', [ReportController::class, 'bid_win'])->name('reports.bid_win');
        Route::post('reports/bid-win/filter', [ReportController::class, 'filter_bid_win'])->name('reports.bid_win.filter');
        Route::get('reports/customer-sell', [ReportController::class, 'customer_sell'])->name('reports.customer_sell');
        Route::get('reports/deposit', [ReportController::class, 'deposit'])->name('reports.deposit');
        Route::get('reports/withdraw', [ReportController::class, 'withdraw'])->name('reports.withdraw');
        Route::get('reports/referral', [ReportController::class, 'referral'])->name('reports.referral');
        Route::get('reports/transfer-point', [ReportController::class, 'transfer_point'])->name('reports.transfer_point');
        Route::get('reports/user-bid', [ReportController::class, 'user_bid'])->name('reports.user_bid');
        Route::post('reports/user-bid/filter', [ReportController::class, 'filter_user_bid'])->name('reports.user_bid.filter');
        Route::get('reports/winning', [ReportController::class, 'winning'])->name('reports.winning');
        Route::get('user-bid-history', [ReportController::class, 'user_bid_history'])->name('user_bid_history');
        Route::post('user-bid-history/filter', [ReportController::class, 'filter_user_bid_history'])->name('user_bid_history.filter');
        Route::get('withdraw', [ReportController::class, 'withdraw'])->name('withdraw');
        Route::get('deposit', [ReportController::class, 'deposit'])->name('deposit');

        // Wallet
        Route::get('wallet/fund-request', [WalletController::class, 'fund_request'])->name('wallet.fund_request');
        Route::post('wallet/fund-request/{id}/approve', [WalletController::class, 'approveDeposit'])->name('deposit.approve');
        Route::post('wallet/fund-request/{id}/reject', [WalletController::class, 'rejectDeposit'])->name('deposit.reject');
        Route::get('wallet/withdraw-request', [WalletController::class, 'withdraw_request'])->name('wallet.withdraw_request');
        Route::post('wallet/withdraw-request/{id}/approve', [WalletController::class, 'approveWithdraw'])->name('withdraw.approve');
        Route::post('wallet/withdraw-request/{id}/reject', [WalletController::class, 'rejectWithdraw'])->name('withdraw.reject');
        Route::get('wallet/add-fund', [WalletController::class, 'add_fund'])->name('wallet.add_fund');
        Route::post('wallet/add-fund', [WalletController::class, 'addFundStore'])->name('wallet.add_fund.store');
        Route::get('wallet/bid-report', [WalletController::class, 'bid_report'])->name('wallet.bid_report');
        Route::post('wallet/bid-report/filter', [WalletController::class, 'bidReportFilter'])->name('wallet.bid_report.filter');

        // Notices
        Route::get('notice', [NoticeController::class, 'index'])->name('notice.index');
        Route::post('notice/send', [NoticeController::class, 'send'])->name('notice.send');

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('main', [SettingController::class, 'main'])->name('main');
            Route::post('main', [SettingController::class, 'updateMain'])->name('main.update');
            Route::get('contact', [SettingController::class, 'contact'])->name('contact');
            Route::post('contact', [SettingController::class, 'updateContact'])->name('contact.update');
            Route::get('clear-data', [SettingController::class, 'clear_data'])->name('clear_data');
            Route::get('slider-images', [SettingController::class, 'slider_images'])->name('slider_images');
            Route::get('how-to-play', [SettingController::class, 'how_to_play'])->name('how_to_play');
            Route::post('how-to-play/store', [SettingController::class, 'storeHowToPlay'])->name('how_to_play.store');
            Route::post('how-to-play/{id}/update', [SettingController::class, 'updateHowToPlay'])->name('how_to_play.update');
            Route::delete('how-to-play/{id}', [SettingController::class, 'destroyHowToPlay'])->name('how_to_play.destroy');
        });

        // Queries
        Route::get('queries', [UserQueryController::class, 'index'])->name('queries.index');
        Route::post('queries/reply', [UserQueryController::class, 'reply'])->name('queries.reply');
        Route::post('queries/{id}/status', [UserQueryController::class, 'updateStatus'])->name('queries.status');
        Route::delete('queries/{id}', [UserQueryController::class, 'destroy'])->name('queries.destroy');

        // Sub Admin
        Route::get('sub-admins', [SubAdminController::class, 'index'])->name('sub_admin.index');
        Route::post('sub-admins/store', [SubAdminController::class, 'store'])->name('sub_admin.store');
        Route::post('sub-admins/{id}/update', [SubAdminController::class, 'update'])->name('sub_admin.update');
        Route::post('sub-admins/{id}/toggle', [SubAdminController::class, 'toggle'])->name('sub_admin.toggle');
        Route::delete('sub-admins/{id}', [SubAdminController::class, 'destroy'])->name('sub_admin.destroy');

        // Result (main market)
        Route::prefix('result')->name('result.')->group(function () {
            Route::post('/context', [ResultController::class, 'getContext']);
            Route::post('/save-draft', [ResultController::class, 'saveDraft'])->name('save_draft');
            Route::get('/winners/{result_id}', [ResultController::class, 'winners'])->name('winners');
            Route::post('/declare', [ResultController::class, 'declareWinners'])->name('declare_winners');
            Route::get('/winning-predictions/search', [ResultController::class, 'searchWinningPredictions'])->name('winning_predictions.search');
        });

        // Starline
        Route::prefix('starline')->name('starline.')->group(function () {
            Route::get('game-name', [StarlineController::class, 'game_name'])->name('game_name');
            Route::get('rates', [StarlineController::class, 'rates'])->name('rates');
            Route::post('rates/update', [StarlineController::class, 'update_rates'])->name('rates.update');
            Route::post('store', [StarlineController::class, 'store'])->name('store');
            Route::post('{id}/update', [StarlineController::class, 'update'])->name('update');
            Route::get('{id}/schedule', [StarlineController::class, 'getSchedule'])->name('schedule.get');
            Route::post('{id}/schedule', [StarlineController::class, 'updateSchedule'])->name('schedule.update');
            Route::get('bid-history', [StarlineController::class, 'bid_history'])->name('bid_history');
            Route::post('bid-history/filter', [StarlineController::class, 'filter_bid_history'])->name('bid_history.filter');
            Route::get('declare-result', [StarlineController::class, 'declare_result'])->name('declare_result');
            Route::post('result/context', [StarlineController::class, 'getContext'])->name('result.context');
            Route::post('result/save-draft', [StarlineController::class, 'saveDraft'])->name('result.save_draft');
            Route::get('result/winners/{result}', [StarlineController::class, 'winners'])->name('result.winners');
            Route::post('result/declare', [StarlineController::class, 'declareWinners'])->name('result.declare');
            Route::get('result-history', [StarlineController::class, 'result_history'])->name('result_history');
            Route::get('sell-report', [StarlineController::class, 'sell_report'])->name('sell_report');
            Route::post('sell-report/filter', [StarlineController::class, 'sell_report_filter'])->name('sell_report.filter');
            Route::get('winning-report', [StarlineController::class, 'winning_report'])->name('winning_report');
            Route::post('winning-report/filter', [StarlineController::class, 'winning_report_filter'])->name('winning_report.filter');
            Route::get('winning-prediction', [StarlineController::class, 'winning_prediction'])->name('winning_prediction');
            Route::get('winning-predictions/search', [StarlineController::class, 'searchStarlineWinningPredictions'])->name('winning_predictions.search');
        });

        // Gali Disawar
        Route::prefix('gali-disawar')->name('gali_disawar.')->group(function () {
            Route::get('game_name', [GaliDisawarController::class, 'game_name'])->name('game_name');
            Route::get('rates', [GaliDisawarController::class, 'rates'])->name('rates');
            Route::post('rates/update', [GaliDisawarController::class, 'update_rates'])->name('rates.update');
            Route::post('store', [GaliDisawarController::class, 'store'])->name('store');
            Route::post('{id}/update', [GaliDisawarController::class, 'update'])->name('update');
            Route::get('{id}/schedule', [GaliDisawarController::class, 'getSchedule'])->name('schedule.get');
            Route::post('{id}/schedule', [GaliDisawarController::class, 'updateSchedule'])->name('schedule.update');
            Route::get('bid-history', [GaliDisawarController::class, 'bid_history'])->name('bid_history');
            Route::post('bid-history/filter', [GaliDisawarController::class, 'filter_bid_history'])->name('bid_history.filter');
            Route::get('declare-result', [GaliDisawarController::class, 'declare_result'])->name('declare_result');
            Route::post('result/context', [GaliDisawarController::class, 'getContext'])->name('result.context');
            Route::post('result/save-draft', [GaliDisawarController::class, 'saveDraft'])->name('result.save_draft');
            Route::get('result/winners/{result}', [GaliDisawarController::class, 'winners'])->name('result.winners');
            Route::post('result/declare', [GaliDisawarController::class, 'declareWinners'])->name('result.declare');
            Route::get('result-history', [GaliDisawarController::class, 'result_history'])->name('result_history');
            Route::get('sell-report', [GaliDisawarController::class, 'sell_report'])->name('sell_report');
            Route::post('sell-report/filter', [GaliDisawarController::class, 'sell_report_filter'])->name('sell_report.filter');
            Route::get('winning-report', [GaliDisawarController::class, 'winning_report'])->name('winning_report');
            Route::post('winning-report/filter', [GaliDisawarController::class, 'winning_report_filter'])->name('winning_report.filter');
            Route::get('winning-prediction', [GaliDisawarController::class, 'winning_prediction'])->name('winning_prediction');
            Route::get('winning-predictions/search', [GaliDisawarController::class, 'searchWinningPredictions'])->name('winning_predictions.search');
        });
    });
});

require __DIR__.'/auth.php';
