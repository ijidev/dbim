@extends('admin.layouts.app')

@section('title', 'Financial Ledger')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Digital Account Book</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manual financial records and ledger</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.finance.index') }}" class="btn btn-outline">Dashboard</a>
            <a href="{{ route('admin.finance.ledger.create') }}" class="btn btn-primary">+ Add Record</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th class="hide-mobile">Description</th>
                        <th class="hide-mobile">Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                    <tr>
                        <td>{{ $record->entry_date->format('M d, Y') }}</td>
                        <td>
                            @if($record->type === 'income')
                                <span class="badge badge-success">Income</span>
                            @else
                                <span class="badge badge-danger">Expense</span>
                            @endif
                        </td>
                        <td style="font-weight: 600;">{{ $record->category }}</td>
                        <td style="font-weight: 700; color: {{ $record->type === 'income' ? '#16a34a' : '#dc2626' }};">
                            {{ $record->type === 'income' ? '+' : '-' }}₦{{ number_format($record->amount, 2) }}
                        </td>
                        <td class="hide-mobile">{{ Str::limit($record->description, 50) }}</td>
                        <td class="hide-mobile">{{ $record->recordedBy->name ?? 'System' }}</td>
                        <td>
                            <form action="{{ route('admin.finance.ledger.destroy', $record->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this record?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 4rem; color: #94a3b8;">
                            <div style="font-size: 2.5rem; margin-bottom: 1rem;">📖</div>
                            No records found in the ledger yet. <br>
                            <a href="{{ route('admin.finance.ledger.create') }}" style="color: var(--primary-color); font-weight: 600; margin-top: 1rem; display: inline-block;">Add your first entry</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $records->links() }}
    </div>
@endsection
