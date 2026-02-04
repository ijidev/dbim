@extends('admin.layouts.app')

@section('title', 'Donations')

@section('content')
    <div class="data-card">
        <div class="data-card-header">
            <h3 class="data-card-title">All Donations</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor</th>
                        <th class="hide-mobile">Email</th>
                        <th>Amount</th>
                        <th class="hide-mobile">Method</th>
                        <th>Status</th>
                        <th class="hide-mobile">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                    <tr>
                        <td>#{{ $donation->id }}</td>
                        <td style="font-weight: 600;">{{ $donation->donor_name ?? 'Anonymous' }}</td>
                        <td class="hide-mobile">{{ $donation->donor_email ?? '-' }}</td>
                        <td style="font-weight: 700;">₦{{ number_format($donation->amount, 2) }}</td>
                        <td class="hide-mobile">{{ ucfirst($donation->payment_method) }}</td>
                        <td>
                            @if($donation->status === 'completed')
                                <span class="badge badge-success">Completed</span>
                            @elseif($donation->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Failed</span>
                            @endif
                        </td>
                        <td class="hide-mobile">{{ $donation->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align: center; color: #94a3b8; padding: 3rem;">No donations recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $donations->links() }}
    </div>
@endsection
