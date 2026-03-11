@if($transactions->count())
    @foreach($transactions as $tx)
        <div class="statement-card">

<div class="statement-header">

<div class="statement-left">

<div class="statement-icon {{ $tx->type == 'credit' ? 'icon-credit' : 'icon-debit' }}">
<i class="fa-solid {{ $tx->type == 'credit' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
</div>

<div>

<div class="statement-type">
{{ ucfirst($tx->type) }}
</div>

<div class="statement-date">
{{ $tx->created_at->format('M d, Y • h:i A') }}
</div>

</div>
</div>

<div class="statement-amount {{ $tx->type == 'credit' ? 'amount-credit' : 'amount-debit' }}">
{{ $tx->type == 'credit' ? '+' : '-' }}₹{{ $tx->amount }}
</div>

</div>


<div class="statement-body">
{{ ucfirst($tx->reason ?? 'Wallet Transaction') }}
</div>


<div class="balance-row">
<span>Previous Balance</span>
<span>₹{{ $tx->balance_before ?? '0' }}</span>
</div>

<div class="balance-row">
<span>Current Balance</span>
<span>₹{{ $tx->balance_after ?? '0' }}</span>
</div>

</div>
    @endforeach

    <div class="pagination justify-content-center">
        {!! $transactions->links('pagination::bootstrap-5') !!}
    </div>
@else
    <div class="text-center p-3 text-muted">No transactions found.</div>
@endif
