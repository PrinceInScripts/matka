@php
    use App\Models\Setting;
    $siteName = Setting::get('site_name') ?? 'Matka Play';
    $siteLogo = Setting::get('site_logo');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>{{ $siteName }} | {{ $marketName }} Chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #d6e8f7;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ── TOP BAR ── */
        .chart-topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            max-width: 500px;
            height: 52px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        .chart-back {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #1e40af;
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .chart-title-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            justify-content: center;
        }

        .chart-title-text {
            font-weight: 800;
            font-size: 13px;
            color: #1e40af;
            letter-spacing: .3px;
        }

        /* ── SCROLL CONTAINER ── */
        .chart-scroll {
            padding: 60px 0 80px;
            min-height: 100dvh;
            background: #d6e8f7;
        }

        /* ══════════════════════════════════════════
       MAIN MARKET CHART — EXACT image 2 structure
       Each day cell = 3 sub-cols: open | jodi | close
       ══════════════════════════════════════════ */
        .chart-page-title {
            text-align: center;
            font-size: 18px;
            font-weight: 900;
            color: #1e3a8a;
            padding: 14px 8px 10px;
            letter-spacing: .5px;
        }

        /* One week block */
        .wk {
            background: #fff;
            margin: 0 4px 8px;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
        }

        /* Day-name header row */
        .wk-head {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: #1e40af;
        }

        .wk-day {
            text-align: center;
            padding: 7px 2px;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            border-right: 1px solid rgba(255, 255, 255, .15);
        }

        .wk-day:last-child {
            border-right: none;
        }

        /* Date sub-header row */
        .wk-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: #bdd5ef;
        }

        .wk-date {
            text-align: center;
            padding: 3px 1px;
            font-size: 9px;
            color: #1e3a8a;
            font-weight: 700;
            border-right: 1px solid #9bbad8;
        }

        .wk-date:last-child {
            border-right: none;
        }

        /* Results row — 7 cells */
        .wk-row {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        /* Each day cell: 3 sub-columns */
        .dc {
            border-right: 1px solid #d0e4f3;
            min-height: 72px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            /* open | jodi | close */
            align-items: center;
        }

        .dc:last-child {
            border-right: none;
        }

        .dc:nth-child(odd) {
            background: #f0f7ff;
        }

        .dc:nth-child(even) {
            background: #fff;
        }

        /* open panna sub-col — digits stacked */
        .dc-open {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4px 1px;
            gap: 0;
        }

        .dc-open span {
            font-size: 10px;
            font-weight: 700;
            color: #1e40af;
            line-height: 1.35;
            display: block;
            text-align: center;
        }

        /* jodi center sub-col */
        .dc-jodi {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2px 1px;
        }

        .dc-jodi span {
            font-size: 15px;
            font-weight: 900;
            color: #dc2626;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
        }

        /* close panna sub-col */
        .dc-close {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4px 1px;
            gap: 0;
        }

        .dc-close span {
            font-size: 10px;
            font-weight: 700;
            color: #1e40af;
            line-height: 1.35;
            display: block;
            text-align: center;
        }

        /* Empty placeholders */
        .dc-empty {
            font-size: 10px;
            color: #b0c8e0;
            font-weight: 600;
            text-align: center;
        }

        /* Jodi empty */
        .jodi-empty {
            font-size: 12px;
            font-weight: 700;
            color: #b0c8e0;
        }

        /* ══ STARLINE CHART ══ */
        .sl-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .sl-table {
            border-collapse: collapse;
            background: #fff;
            width: max-content;
            min-width: 100%;
        }

        .sl-table th {
            background: #1e40af;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #1a3a9a;
            white-space: nowrap;
        }

        .sl-table tr:nth-child(odd) td {
            background: #f0f7ff;
        }

        .sl-table tr:nth-child(even) td {
            background: #fff;
        }

        .sl-table td {
            padding: 3px 2px;
            text-align: center;
            border: 1px solid #cce0f5;
            vertical-align: middle;
        }

        .sl-date {
            font-size: 9px;
            font-weight: 800;
            color: #1e3a8a;
            white-space: nowrap;
            background: #bdd5ef !important;
            min-width: 46px;
            padding: 4px 3px;
        }

        .sl-pana {
            font-size: 9px;
            font-weight: 700;
            color: #1e40af;
            display: block;
            line-height: 1.3;
        }

        .sl-digit {
            font-size: 13px;
            font-weight: 900;
            color: #dc2626;
            display: block;
            line-height: 1.2;
        }

        .sl-na {
            font-size: 9px;
            color: #b0c8e0;
            font-weight: 600;
        }

        /* ══ GALI DISAWAR CHART ══ */
        .gd-table {
            width: calc(100% - 8px);
            margin: 0 4px;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        .gd-table thead th {
            background: #1e40af;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            padding: 10px 8px;
            text-align: center;
        }

        .gd-table tbody tr:nth-child(odd) {
            background: #f0f7ff;
        }

        .gd-table tbody tr:nth-child(even) {
            background: #fff;
        }

        .gd-table tbody td {
            padding: 9px 6px;
            text-align: center;
            border-bottom: 1px solid #d0e4f3;
        }

        .gd-date {
            font-size: 11px;
            font-weight: 800;
            color: #1e3a8a;
        }

        .gd-jodi {
            font-size: 22px;
            font-weight: 900;
            color: #dc2626;
            display: block;
        }

        .gd-digit {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
        }

        .gd-pana {
            font-size: 11px;
            color: #1e40af;
            font-weight: 700;
        }

        /* shared */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 44px;
            color: #93c5fd;
            display: block;
            margin-bottom: 14px;
        }
    </style>
</head>

<body>
    <div class="app-layout">
        <div class="left-area">

            {{-- TOP BAR --}}
            <div class="chart-topbar">
                <button class="chart-back" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
                <div class="chart-title-wrap">
                    @if ($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}"
                            style="height:22px;border-radius:4px;vertical-align:middle;">
                    @endif
                    <span class="chart-title-text">{{ strtoupper($marketName) }} CHART</span>
                </div>
                @include('components.walletinfo')
            </div>

            <div class="chart-scroll">

                {{-- ══════════════════════════════════════════════
           MAIN MARKET — exact image 2 structure
           3 sub-columns: open panna | jodi | close panna
           each panna = digits stacked one per line
           ══════════════════════════════════════════════ --}}
                @if ($market_type === 'main')
                    <div class="chart-page-title">{{ strtoupper($marketName) }} Chart</div>

                    @php
                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

                        // split panna string into array of single chars
                        function pannaChars($p)
                        {
                            if (!$p || $p === '***') {
                                return ['*', '*', '*'];
                            }
                            $chars = str_split(trim($p));
                            // pad to 3 chars
                            while (count($chars) < 3) {
                                $chars[] = '*';
                            }
                            return array_slice($chars, 0, 3);
                        }

                        $grouped = collect();
                        foreach ($results as $r) {
                            $date = \Carbon\Carbon::parse($r->result_date);
                            $wk = $date->format('o-W');
                            $dayIdx = (int) $date->format('N') - 1;
                            if (!$grouped->has($wk)) {
                                $mon = $date->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                                $grouped[$wk] = ['monday' => $mon, 'days' => array_fill(0, 7, null)];
                            }
                            $entry = $grouped[$wk];
                            $entry['days'][$dayIdx] = $r;
                            $grouped[$wk] = $entry;
                        }
                        $grouped = $grouped->sortKeysDesc();
                    @endphp

                    @if ($grouped->isEmpty())
                        <div class="empty-state"><i class="fa fa-chart-bar"></i>
                            <p>No results declared yet</p>
                        </div>
                    @else
                        @foreach ($grouped as $week)
                            <div class="wk">
                                {{-- Day names --}}
                                <div class="wk-head">
                                    @foreach ($days as $d)
                                        <div class="wk-day">{{ $d }}</div>
                                    @endforeach
                                </div>
                                {{-- Dates --}}
                                <div class="wk-dates">
                                    @for ($i = 0; $i < 7; $i++)
                                        @php $dt = $week['monday']->copy()->addDays($i); @endphp
                                        <div class="wk-date">{{ $dt->format('d/m/y') }}</div>
                                    @endfor
                                </div>
                                {{-- Results — each cell = 3 sub-columns --}}
                                <div class="wk-row">
                                    @for ($i = 0; $i < 7; $i++)
                                        @php $r = $week['days'][$i]; @endphp
                                        <div class="dc">
                                            @if ($r)
                                                @php
                                                    $op = pannaChars($r->open_panna ?? null);
                                                    $cl = pannaChars($r->close_panna ?? null);
                                                    $jodiVal =
                                                        $r->open_digit !== null && $r->close_digit !== null
                                                            ? $r->open_digit . $r->close_digit
                                                            : null;
                                                @endphp
                                                {{-- Open panna: each digit stacked --}}
                                                <div class="dc-open">
                                                    @foreach ($op as $ch)
                                                        <span>{{ $ch }}</span>
                                                    @endforeach
                                                </div>
                                                {{-- Jodi --}}
                                                <div class="dc-jodi">
                                                    @if ($jodiVal)
                                                        <span>{{ $jodiVal }}</span>
                                                    @else
                                                        <span class="jodi-empty">**</span>
                                                    @endif
                                                </div>
                                                {{-- Close panna: each digit stacked --}}
                                                <div class="dc-close">
                                                    @foreach ($cl as $ch)
                                                        <span>{{ $ch }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                {{-- Empty cell --}}
                                                <div class="dc-open">
                                                    <span class="dc-empty">*</span>
                                                    <span class="dc-empty">*</span>
                                                    <span class="dc-empty">*</span>
                                                </div>
                                                <div class="dc-jodi"><span class="jodi-empty">**</span></div>
                                                <div class="dc-close">
                                                    <span class="dc-empty">*</span>
                                                    <span class="dc-empty">*</span>
                                                    <span class="dc-empty">*</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    @endif


                    {{-- ══════════════════════════════════════
           STARLINE — rows=dates, cols=time slots
           ══════════════════════════════════════ --}}
                @elseif($market_type === 'starline')
                    @php
                        $slots = $extraData['slots'] ?? collect();
                        $byDate = $extraData['byDate'] ?? [];
                    @endphp
                    <div class="chart-page-title">{{ $siteName }} Starline Chart</div>

                    @if (empty($byDate) || $slots->isEmpty())
                        <div class="empty-state"><i class="fa fa-star"></i>
                            <p>No starline results yet</p>
                        </div>
                    @else
                        <div class="sl-scroll">
                            <table class="sl-table">
                                <thead>
                                    <tr>
                                        <th style="min-width:46px;position:sticky;left:0;z-index:2;background:#1a3a9a;">
                                            Date</th>
                                        @foreach ($slots as $slot)
                                            <th style="min-width:34px;">{{ $slot->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($byDate as $dateStr => $slotResults)
                                        <tr>
                                            <td class="sl-date" style="position:sticky;left:0;z-index:1;">
                                                {{ \Carbon\Carbon::parse($dateStr)->format('d-m-y') }}
                                            </td>
                                            @foreach ($slots as $slot)
                                                @php $r = $slotResults[$slot->id] ?? null; @endphp
                                                <td>
                                                    @if ($r)
                                                        <span class="sl-pana">{{ $r->result_pana ?: '***' }}</span>
                                                        <span class="sl-digit">{{ $r->result_digit ?: '*' }}</span>
                                                    @else
                                                        <span class="sl-pana sl-na">***</span>
                                                        <span class="sl-na">*</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif


                    {{-- ══════════════════════════════════════
           GALI DISAWAR — date list with jodi
           ══════════════════════════════════════ --}}
                @elseif($market_type === 'gali_disawar')
                    <div class="chart-page-title">{{ strtoupper($marketName) }} Chart</div>

                    @if ($results->isEmpty())
                        <div class="empty-state"><i class="fa fa-dice"></i>
                            <p>No results declared yet</p>
                        </div>
                    @else
                        <table class="gd-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Jodi</th>
                                    <th>Pana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $r)
                                    @php $d = \Carbon\Carbon::parse($r->draw_date); @endphp
                                    <tr>
                                        <td>
                                            <div class="gd-date">{{ $d->format('d-m-Y') }}</div>
                                            <div style="font-size:9px;color:#64748b">{{ $d->format('D') }}</div>
                                        </td>
                                        <td>
                                            @if ($r->result_jodi)
                                                <div class="gd-jodi">{{ $r->result_jodi }}</div>
                                                <div class="gd-digit">{{ $r->result_digit }}</div>
                                            @else
                                                <span style="color:#b0c8e0;font-weight:700">**</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($r->result_panna)
                                                <div class="gd-pana">{{ $r->result_panna }}</div>
                                            @else
                                                <span style="color:#b0c8e0;font-weight:700">***</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                @endif
            </div>{{-- /chart-scroll --}}

            @include('components.bottombar')
        </div>
        @include('components.rightside')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
