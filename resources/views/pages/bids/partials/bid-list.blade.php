@if($bids->count())
  @foreach($bids as $bid)
  <div class="bid-card status-{{ $bid->status }}">
    <div class="bid-header">
      <div class="bid-market">
        <span style="font-size:10px;background:#eff6ff;color:#2563eb;padding:2px 7px;border-radius:10px;margin-right:4px;font-weight:700">
          {{ strtoupper($bid->market_type ?? 'MAIN') }}
        </span>
        {{ $bid->market->name ?? '—' }}
      </div>
      <span class="status-badge badge-{{ $bid->status }}">{{ ucfirst($bid->status) }}</span>
    </div>
    <div class="bid-row">
      <span class="text-muted">Game Type</span>
      <strong>{{ $bid->gameType->name ?? '—' }}</strong>
    </div>
    <div class="bid-row">
      <span class="text-muted">Session</span>
      <strong>{{ strtoupper($bid->session ?? 'OPEN') }}</strong>
    </div>
    <div class="bid-row">
      <span class="text-muted">Number</span>
      <span class="bid-number">{{ $bid->number }}</span>
    </div>
    <div class="bid-row">
      <span class="text-muted">Bet Amount</span>
      <span class="bid-amount">₹{{ number_format($bid->amount, 2) }}</span>
    </div>
    @if($bid->status === 'won')
    <div class="bid-row">
      <span class="text-muted">Win Amount</span>
      <span class="win-amount"><i class="fa fa-trophy me-1"></i>₹{{ number_format($bid->winning_amount ?? 0, 2) }}</span>
    </div>
    @endif
    <div class="bid-foot">
      <span><i class="fa fa-calendar me-1"></i>{{ $bid->created_at->format('d M Y') }}</span>
      <span><i class="fa fa-clock me-1"></i>{{ $bid->created_at->format('h:i A') }}</span>
      @if($bid->draw_date)
      <span><i class="fa fa-dice me-1"></i>Draw: {{ \Carbon\Carbon::parse($bid->draw_date)->format('d M Y') }}</span>
      @endif
    </div>
  </div>
  @endforeach
  <div class="d-flex justify-content-center mt-3">
    {{ $bids->links('pagination::bootstrap-5') }}
  </div>
@else
  <div class="empty-state">
    <i class="fa fa-receipt"></i>
    <p style="font-size:14px;font-weight:600">No bids found</p>
    <p style="font-size:12px">Try changing your filters</p>
  </div>
@endif
