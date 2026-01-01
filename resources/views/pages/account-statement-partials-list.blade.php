@if($transactions->count())
    @foreach($transactions as $tx)
        <div class="statement-card">
            <div class="date">{{ $tx->created_at->format('M d, Y h:i A') }}</div>
            <div class="particular">{{ ucfirst($tx->remark ?? $tx->type) }}</div>

            <div class="amounts mt-2">
                <div>
                    <span class="label">Previous Amount:</span>
                    <span class="value neutral">₹{{ $tx->balance_before ?? '0' }}</span>
                </div>
                <div>
                    <span class="label">Transaction Amount:</span>
                    <span class="value {{ $tx->type === 'credit' ? 'positive' : 'negative' }}">
                        {{ $tx->type === 'credit' ? '+' : '-' }}₹{{ $tx->amount }}
                    </span>
                </div>
                <div>
                    <span class="label">Current Amount:</span>
                    <span class="value neutral">₹{{ $tx->balance_after ?? '0' }}</span>
                </div>
            </div>
        </div>
    @endforeach

    <div class="pagination justify-content-center">
        {!! $transactions->links('pagination::bootstrap-5') !!}
    </div>
@else
    <div class="text-center p-3 text-muted">No transactions found.</div>
@endif
