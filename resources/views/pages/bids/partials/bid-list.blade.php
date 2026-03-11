@if ($bids->count())

@foreach ($bids as $bid)

<div class="bid-card">

<div class="bid-header">

<div class="bid-market">
{{ $bid->market->name ?? '-' }}
</div>

<div class="bid-status
@if($bid->status == 'won') status-win
@elseif($bid->status == 'lost') status-loss
@else status-pending
@endif">

{{ ucfirst($bid->status) }}

</div>

</div>


<div class="bid-body">

<div class="bid-row">

<span>Game</span>
<strong>{{ $bid->gameType->name ?? '-' }}</strong>

</div>

<div class="bid-row">

<span>Session</span>
<strong>{{ strtoupper($bid->session) }}</strong>

</div>

<div class="bid-row">

<span>Number</span>
<strong class="bid-number">{{ $bid->number }}</strong>

</div>

<div class="bid-row">

<span>Amount</span>
<strong class="bid-amount">₹{{ number_format($bid->amount,2) }}</strong>

</div>

</div>


<div class="bid-footer">

<span class="bid-date">
{{ $bid->created_at->format('d M Y • h:i A') }}
</span>

</div>

</div>

@endforeach


<div class="text-center mt-3">
{{ $bids->links('pagination::bootstrap-5') }}
</div>

@else

<div class="empty-bids">

<i class="fa fa-receipt"></i>
<p>No bids found</p>

</div>

@endif