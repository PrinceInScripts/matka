@if($bids->count())
  @foreach($bids as $b)
  <div class="bid-card">
    <div class="bid-header">
      <div class="game-name">{{ optional($b->starline)->name ?? 'Starline' }}</div>
      <span class="status-badge status-{{ $b->status }}">{{ ucfirst($b->status) }}</span>
    </div>
    <div class="bid-row"><span class="text-muted">Game Type</span><strong>{{ optional($b->gameType)->name ?? '—' }}</strong></div>
    <div class="bid-row"><span class="text-muted">Number</span><span class="bid-number">{{ $b->bet_value }}</span></div>
    <div class="bid-row"><span class="text-muted">Bet Amount</span><span class="bid-amount">₹{{ number_format($b->amount,2) }}</span></div>
    @if($b->status === 'won')
    <div class="bid-row"><span class="text-muted">Win Amount</span><span class="win-amount"><i class="fa fa-trophy me-1"></i>₹{{ number_format($b->winning_amount,2) }}</span></div>
    @endif
    <div class="bid-foot"><i class="fa fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($b->bid_date ?? $b->created_at)->format('d M Y • h:i A') }}</div>
  </div>
  @endforeach
  <div class="d-flex justify-content-center mt-2">{{ $bids->links('pagination::bootstrap-5') }}</div>
@else
  <div style="text-align:center;padding:40px;color:#94a3b8">
    <i class="fa fa-inbox" style="font-size:40px;display:block;margin-bottom:12px"></i>
    <p style="font-size:14px">No records found</p>
  </div>
@endif
