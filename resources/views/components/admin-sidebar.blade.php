<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
        <span class="brand-text font-weight-light">Matka Admin</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="Admin">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth('admin')->user()->name ?? 'Admin' }}</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                    </a>
                </li>

                {{-- Users --}}
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i><p>User Management</p>
                    </a>
                </li>

                {{-- Declare Result --}}
                <li class="nav-item">
                    <a href="{{ route('admin.declare_result') }}" class="nav-link {{ request()->routeIs('admin.declare_result') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i><p>Declare Result</p>
                    </a>
                </li>

                {{-- Winning Predictions --}}
                <li class="nav-item">
                    <a href="{{ route('admin.winning_predictions') }}" class="nav-link {{ request()->routeIs('admin.winning_predictions') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trophy"></i><p>Winning Predictions</p>
                    </a>
                </li>

                <li class="nav-header">History Management</li>

                {{-- Reports --}}
                @php
                $reportRoutes = [
                    'admin.user_bid_history','admin.reports.bid_win','admin.reports.customer_sell',
                    'admin.reports.winning','admin.reports.transfer_point','admin.reports.withdraw',
                    'admin.reports.referral','admin.reports.deposit','admin.reports.user_bid',
                ];
                @endphp
                <li class="nav-item {{ request()->routeIs($reportRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($reportRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Report Management<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user_bid_history') }}" class="nav-link {{ request()->routeIs('admin.user_bid_history') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i><p>User Bid History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.customer_sell') }}" class="nav-link {{ request()->routeIs('admin.reports.customer_sell') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i><p>Customer Sell Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.winning') }}" class="nav-link {{ request()->routeIs('admin.reports.winning') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-trophy"></i><p>Winning Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.transfer_point') }}" class="nav-link {{ request()->routeIs('admin.reports.transfer_point') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-exchange-alt"></i><p>Transfer Point Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.bid_win') }}" class="nav-link {{ request()->routeIs('admin.reports.bid_win') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-check-circle"></i><p>Bid Win Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.withdraw') }}" class="nav-link {{ request()->routeIs('admin.reports.withdraw') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-wallet"></i><p>Withdraw Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.referral') }}" class="nav-link {{ request()->routeIs('admin.reports.referral') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i><p>Referral History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.deposit') }}" class="nav-link {{ request()->routeIs('admin.reports.deposit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-piggy-bank"></i><p>Deposit History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Wallet Management --}}
                @php
                $walletRoutes = ['admin.wallet.fund_request','admin.wallet.withdraw_request','admin.wallet.add_fund','admin.wallet.bid_report'];
                @endphp
                <li class="nav-item {{ request()->routeIs($walletRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($walletRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Wallet Management<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.wallet.fund_request') }}" class="nav-link {{ request()->routeIs('admin.wallet.fund_request') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-usd nav-icon"></i><p>Fund Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.wallet.withdraw_request') }}" class="nav-link {{ request()->routeIs('admin.wallet.withdraw_request') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave nav-icon"></i><p>Withdraw Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.wallet.add_fund') }}" class="nav-link {{ request()->routeIs('admin.wallet.add_fund') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle nav-icon"></i><p>Add Fund</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.wallet.bid_report') }}" class="nav-link {{ request()->routeIs('admin.wallet.bid_report') ? 'active' : '' }}">
                                <i class="fas fa-receipt nav-icon"></i><p>Bid Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Notice Management --}}
                @php $noticeRoutes = ['admin.notice.index','admin.notice.send']; @endphp
                <li class="nav-item {{ request()->routeIs($noticeRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($noticeRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Notice Management<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.notice.index') }}" class="nav-link {{ request()->routeIs('admin.notice.index') ? 'active' : '' }}">
                                <i class="fas fa-newspaper nav-icon"></i><p>All Notices</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.notice.send') }}" class="nav-link {{ request()->routeIs('admin.notice.send') ? 'active' : '' }}">
                                <i class="fas fa-paper-plane nav-icon"></i><p>Send Notification</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Games</li>

                {{-- Game Management --}}
                @php
                $gameManageRoutes = ['admin.game_names','admin.game_management.index','admin.game_management.store','admin.game_management.update'];
                @endphp
                <li class="nav-item {{ request()->routeIs($gameManageRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($gameManageRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>Game Management<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.game_names') }}" class="nav-link {{ request()->routeIs('admin.game_names') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i><p>Game Names</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_management.index') }}" class="nav-link {{ request()->routeIs('admin.game_management.index') ? 'active' : '' }}">
                                <i class="fas fa-cogs nav-icon"></i><p>Game Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Game Numbers --}}
                @php
                $gameNumberRoutes = [
                    'admin.game_numbers.single_digit','admin.game_numbers.jodi_digit',
                    'admin.game_numbers.single_panna','admin.game_numbers.double_panna',
                    'admin.game_numbers.triple_panna','admin.game_numbers.half_sangam',
                    'admin.game_numbers.full_sangam',
                ];
                @endphp
                <li class="nav-item {{ request()->routeIs($gameNumberRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($gameNumberRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Game & Numbers<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.single_digit') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.single_digit') ? 'active' : '' }}">
                                <i class="fas fa-sort-numeric-up nav-icon"></i><p>Single Digit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.jodi_digit') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.jodi_digit') ? 'active' : '' }}">
                                <i class="fas fa-sort-numeric-up-alt nav-icon"></i><p>Jodi Digit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.single_panna') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.single_panna') ? 'active' : '' }}">
                                <i class="fas fa-th nav-icon"></i><p>Single Panna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.double_panna') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.double_panna') ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i><p>Double Panna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.triple_panna') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.triple_panna') ? 'active' : '' }}">
                                <i class="fas fa-cubes nav-icon"></i><p>Triple Panna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.half_sangam') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.half_sangam') ? 'active' : '' }}">
                                <i class="fas fa-compress-arrows-alt nav-icon"></i><p>Half Sangam</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.game_numbers.full_sangam') }}" class="nav-link {{ request()->routeIs('admin.game_numbers.full_sangam') ? 'active' : '' }}">
                                <i class="fas fa-expand-arrows-alt nav-icon"></i><p>Full Sangam</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Starline --}}
                @php
                $starlineRoutes = [
                    'admin.starline.game_name','admin.starline.rates','admin.starline.bid_history',
                    'admin.starline.declare_result','admin.starline.result_history',
                    'admin.starline.sell_report','admin.starline.winning_report','admin.starline.winning_prediction',
                ];
                @endphp
                <li class="nav-item {{ request()->routeIs($starlineRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($starlineRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Starline Management<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.game_name') }}" class="nav-link {{ request()->routeIs('admin.starline.game_name') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i><p>Game Name</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.rates') }}" class="nav-link {{ request()->routeIs('admin.starline.rates') ? 'active' : '' }}">
                                <i class="fas fa-rupee-sign nav-icon"></i><p>Game Rates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.bid_history') }}" class="nav-link {{ request()->routeIs('admin.starline.bid_history') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i><p>Bid History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.declare_result') }}" class="nav-link {{ request()->routeIs('admin.starline.declare_result') ? 'active' : '' }}">
                                <i class="fas fa-check nav-icon"></i><p>Declare Result</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.result_history') }}" class="nav-link {{ request()->routeIs('admin.starline.result_history') ? 'active' : '' }}">
                                <i class="fas fa-clock nav-icon"></i><p>Result History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.sell_report') }}" class="nav-link {{ request()->routeIs('admin.starline.sell_report') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar nav-icon"></i><p>Starline Sell Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.winning_report') }}" class="nav-link {{ request()->routeIs('admin.starline.winning_report') ? 'active' : '' }}">
                                <i class="fas fa-trophy nav-icon"></i><p>Starline Winning Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.starline.winning_prediction') }}" class="nav-link {{ request()->routeIs('admin.starline.winning_prediction') ? 'active' : '' }}">
                                <i class="fas fa-lightbulb nav-icon"></i><p>Starline Winning Prediction</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Gali Disawar --}}
                @php
                $galiRoutes = [
                    'admin.gali_disawar.game_name','admin.gali_disawar.rates','admin.gali_disawar.bid_history',
                    'admin.gali_disawar.declare_result','admin.gali_disawar.result_history',
                    'admin.gali_disawar.sell_report','admin.gali_disawar.winning_report','admin.gali_disawar.winning_prediction',
                ];
                @endphp
                <li class="nav-item {{ request()->routeIs($galiRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($galiRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dice"></i>
                        <p>Gali Disawar Management<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.game_name') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.game_name') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i><p>Game Name</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.rates') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.rates') ? 'active' : '' }}">
                                <i class="fas fa-rupee-sign nav-icon"></i><p>Game Rates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.bid_history') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.bid_history') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i><p>Bid History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.declare_result') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.declare_result') ? 'active' : '' }}">
                                <i class="fas fa-check nav-icon"></i><p>Declare Result</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.result_history') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.result_history') ? 'active' : '' }}">
                                <i class="fas fa-clock nav-icon"></i><p>Result History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.sell_report') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.sell_report') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar nav-icon"></i><p>Gali Disawar Sell Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.winning_report') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.winning_report') ? 'active' : '' }}">
                                <i class="fas fa-trophy nav-icon"></i><p>Gali Disawar Winning Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gali_disawar.winning_prediction') }}" class="nav-link {{ request()->routeIs('admin.gali_disawar.winning_prediction') ? 'active' : '' }}">
                                <i class="fas fa-lightbulb nav-icon"></i><p>Gali Disawar Winning Prediction</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Others</li>

                {{-- Settings --}}
                @php
                $settingRoutes = ['admin.settings.main','admin.settings.contact','admin.settings.clear_data','admin.settings.slider_images','admin.settings.how_to_play'];
                @endphp
                <li class="nav-item {{ request()->routeIs($settingRoutes) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($settingRoutes) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.main') }}" class="nav-link {{ request()->routeIs('admin.settings.main') ? 'active' : '' }}">
                                <i class="fas fa-sliders-h nav-icon"></i><p>Main Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.contact') }}" class="nav-link {{ request()->routeIs('admin.settings.contact') ? 'active' : '' }}">
                                <i class="fas fa-phone nav-icon"></i><p>Contact Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.clear_data') }}" class="nav-link {{ request()->routeIs('admin.settings.clear_data') ? 'active' : '' }}">
                                <i class="fas fa-trash-alt nav-icon"></i><p>Clear Data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.slider_images') }}" class="nav-link {{ request()->routeIs('admin.settings.slider_images') ? 'active' : '' }}">
                                <i class="fas fa-images nav-icon"></i><p>Slider Images</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.how_to_play') }}" class="nav-link {{ request()->routeIs('admin.settings.how_to_play') ? 'active' : '' }}">
                                <i class="fas fa-question-circle nav-icon"></i><p>How to Play</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Queries --}}
                <li class="nav-item">
                    <a href="{{ route('admin.queries.index') }}" class="nav-link {{ request()->routeIs('admin.queries.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-headset"></i><p>User Query Management</p>
                    </a>
                </li>

                {{-- Sub Admin --}}
                <li class="nav-item">
                    <a href="{{ route('admin.sub_admin.index') }}" class="nav-link {{ request()->routeIs('admin.sub_admin.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i><p>Sub Admin Management</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
