@if ($bids->count())
  @foreach ($bids as $bid)
    <div class="statement-card">
      <div class="date">{{ $bid->created_at->format('M d, Y h:i A') }}</div>
      <div class="particular">
        <strong>{{ $bid->market->name ?? '-' }}</strong> — {{ $bid->gameType->name ?? '-' }}
        <small>({{ ucfirst($bid->session) }})</small><br>
        Number: <strong>{{ $bid->number }}</strong>
      </div>
      <div class="amounts mt-2">
        <div><span class="label">Prev Balance:</span> <span class="value neutral">₹{{ number_format(($bid->walletTransaction->balance_after ?? 0) + $bid->amount, 2) }}</span></div>
        <div><span class="label">Transaction:</span> <span class="value negative">-₹{{ number_format($bid->amount, 2) }}</span></div>
        <div><span class="label">Curr Balance:</span> <span class="value neutral">₹{{ number_format($bid->walletTransaction->balance_after ?? 0, 2) }}</span></div>
        <div><span class="label">Status:</span>
          <span class="value 
            @if($bid->status == 'Won') positive 
            @elseif($bid->status == 'Lost') negative 
            @else neutral @endif">
            {{ ucfirst($bid->status) }}
          </span>
        </div>
      </div>
    </div>
  @endforeach

  <div style="display: flex;justify-content:center" class="text-center">
    {{ $bids->links('pagination::bootstrap-5') }}
  </div>
@else
  <div class="text-center text-muted py-3">
    <i class="fa-regular fa-circle-xmark fa-2x d-block mb-2"></i>
    No bids found.
  </div>
@endif
