@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $siteName }} | {{ $marketName }} Chart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    body{background:#eaf2ff;font-family:'Segoe UI',sans-serif;}
    .home-content{flex:1;overflow-y:auto;background:#eaf2ff;padding:70px 0 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #dce8ff;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    /* CHART TITLE */
    .chart-title{text-align:center;font-size:18px;font-weight:800;color:#1e3a8a;padding:16px 0 8px;letter-spacing:.5px;}
    /* WEEK BLOCK */
    .week-block{background:#fff;border-radius:0;margin-bottom:6px;overflow:hidden;border:1px solid #c7d9f5;}
    .week-header{display:grid;grid-template-columns:repeat(7,1fr);background:#2563eb;}
    .wh-day{text-align:center;padding:5px 2px;color:#fff;font-size:11px;font-weight:700;}
    .week-dates{display:grid;grid-template-columns:repeat(7,1fr);background:#ddeeff;}
    .wd-date{text-align:center;padding:2px 2px;font-size:9px;color:#334155;font-weight:600;border-right:1px solid #c7d9f5;}
    .week-body{display:grid;grid-template-columns:repeat(7,1fr);}
    .day-cell{border-right:1px solid #dce8ff;padding:6px 4px;min-height:64px;display:flex;flex-direction:column;align-items:center;justify-content:center;}
    .day-cell:last-child{border-right:none;}
    .panna-top{font-size:11px;color:#1e40af;font-weight:700;line-height:1.2;text-align:center;}
    .jodi-mid{font-size:15px;font-weight:900;color:#dc2626;margin:2px 0;letter-spacing:1px;}
    .panna-bot{font-size:11px;color:#1e40af;font-weight:700;line-height:1.2;text-align:center;}
    .day-cell.empty .panna-top,.day-cell.empty .panna-bot{color:#94a3b8;}
    .day-cell.empty .jodi-mid{color:#cbd5e1;}
    .no-data{text-align:center;padding:4px 2px;font-size:10px;color:#94a3b8;display:flex;align-items:center;justify-content:center;min-height:64px;}
    /* Starline / Gali cells */
    .sl-digit{font-size:18px;font-weight:900;color:#dc2626;text-align:center;}
    .sl-pana{font-size:11px;color:#1e40af;font-weight:700;text-align:center;margin-top:2px;}
    .gd-jodi{font-size:17px;font-weight:900;color:#dc2626;text-align:center;}
    /* Selector */
    .market-selector{display:flex;gap:8px;overflow-x:auto;padding:8px 12px;background:#fff;border-bottom:1px solid #dce8ff;}
    .mkt-chip{border:1.5px solid #2563eb;border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;color:#2563eb;background:none;white-space:nowrap;}
    .mkt-chip.active{background:#2563eb;color:#fff;}
    /* Year tabs */
    .year-tabs{display:flex;gap:6px;padding:8px 12px;overflow-x:auto;background:#f0f6ff;}
    .year-tab{border:1.5px solid #93c5fd;border-radius:16px;padding:4px 12px;font-size:12px;font-weight:600;color:#1d4ed8;background:#fff;}
    .year-tab.active{background:#1d4ed8;color:#fff;border-color:#1d4ed8;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold text-primary" style="font-size:13px">{{ $marketName }}</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">
      <div class="chart-title">{{ strtoupper($marketName) }} Chart</div>

      @php
        $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

        // Build weekly grid from results
        // Group results by ISO week (year + week number)
        $grouped = collect();

        if ($market_type === 'main') {
            foreach ($results as $r) {
                $date = \Carbon\Carbon::parse($r->result_date);
                $weekKey = $date->format('Y-W');
                $dayKey = $date->format('N') - 1; // 0=Mon .. 6=Sun
                if (!$grouped->has($weekKey)) {
                    // find Monday of this week
                    $monday = $date->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $grouped[$weekKey] = ['monday' => $monday, 'days' => array_fill(0,7,null)];
                }
                $entry = $grouped[$weekKey];
                $entry['days'][$dayKey] = $r;
                $grouped[$weekKey] = $entry;
            }
        } elseif ($market_type === 'starline') {
            foreach ($results as $r) {
                $date = \Carbon\Carbon::parse($r->draw_date);
                $weekKey = $date->format('Y-W');
                $dayKey = $date->format('N') - 1;
                if (!$grouped->has($weekKey)) {
                    $monday = $date->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $grouped[$weekKey] = ['monday' => $monday, 'days' => array_fill(0,7,null)];
                }
                $entry = $grouped[$weekKey];
                $entry['days'][$dayKey] = $r;
                $grouped[$weekKey] = $entry;
            }
        } elseif ($market_type === 'gali_disawar') {
            foreach ($results as $r) {
                $date = \Carbon\Carbon::parse($r->draw_date);
                $weekKey = $date->format('Y-W');
                $dayKey = $date->format('N') - 1;
                if (!$grouped->has($weekKey)) {
                    $monday = $date->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $grouped[$weekKey] = ['monday' => $monday, 'days' => array_fill(0,7,null)];
                }
                $entry = $grouped[$weekKey];
                $entry['days'][$dayKey] = $r;
                $grouped[$weekKey] = $entry;
            }
        }

        // Sort most recent first
        $grouped = $grouped->sortKeysDesc();
      @endphp

      @if($grouped->isEmpty())
      <div style="text-align:center;padding:50px 20px;color:#64748b;">
        <i class="fa fa-chart-bar" style="font-size:40px;color:#93c5fd;display:block;margin-bottom:12px"></i>
        <p style="font-size:14px;font-weight:600">No results declared yet for {{ $marketName }}</p>
        <p style="font-size:12px;color:#94a3b8">Results will appear here once declared</p>
      </div>
      @else

      @foreach($grouped as $weekKey => $week)
      <div class="week-block">
        {{-- Header row: day names --}}
        <div class="week-header">
          @foreach($days as $d)<div class="wh-day">{{ $d }}</div>@endforeach
        </div>
        {{-- Date row --}}
        <div class="week-dates">
          @for($i=0;$i<7;$i++)
          @php $dt = $week['monday']->copy()->addDays($i); @endphp
          <div class="wd-date">{{ $dt->format('d/m') }}</div>
          @endfor
        </div>
        {{-- Result row --}}
        <div class="week-body">
          @for($i=0;$i<7;$i++)
          @php $r = $week['days'][$i]; @endphp
          <div class="day-cell {{ $r ? '' : 'empty' }}">
            @if($r)
              @if($market_type === 'main')
                <div class="panna-top">{{ $r->open_panna ?? '***' }}</div>
                <div class="jodi-mid">{{ ($r->open_digit !== null && $r->close_digit !== null) ? $r->open_digit.$r->close_digit : '**' }}</div>
                <div class="panna-bot">{{ $r->close_panna ?? '***' }}</div>
              @elseif($market_type === 'starline')
                <div class="sl-pana">{{ $r->result_pana ?? '***' }}</div>
                <div class="sl-digit">{{ $r->result_digit ?? '*' }}</div>
              @elseif($market_type === 'gali_disawar')
                <div class="gd-jodi">{{ $r->result_jodi ?? '**' }}</div>
              @endif
            @else
              <div class="no-data">* * *</div>
            @endif
          </div>
          @endfor
        </div>
      </div>
      @endforeach

      @endif
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
