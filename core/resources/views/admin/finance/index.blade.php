@extends('admin.layouts.app')

@section('title', 'Finance Dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Finance & Revenue</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Overview of church income and expenditures</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.finance.ledger') }}" class="btn btn-outline">📖 Open Ledger</a>
            <a href="{{ route('admin.finance.ledger.create') }}" class="btn btn-primary">+ Add Record</a>
        </div>
    </div>

    <!-- Revenue Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">₦{{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-label">Gross Income</div>
                </div>
                <div class="stat-icon green">💰</div>
            </div>
            <span class="stat-change up">↑ All Sources</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">₦{{ number_format($manualExpenses, 2) }}</div>
                    <div class="stat-label">Total Expenses</div>
                </div>
                <div class="stat-icon red" style="background: #fef2f2; color: #ef4444; width: 40px; height: 40px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">📉</div>
            </div>
            <span class="stat-change" style="color: #ef4444;">Outflow</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value" style="color: var(--primary-color);">₦{{ number_format($netBalance, 2) }}</div>
                    <div class="stat-label">Net Balance</div>
                </div>
                <div class="stat-icon blue">⚖️</div>
            </div>
            <span class="stat-change up">Profit/Loss</span>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <!-- Recent Donations -->
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">Recent Donations</h3>
                <a href="{{ route('admin.donations.index') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8125rem;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Donor</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentDonations as $donation)
                        <tr>
                            <td>{{ $donation->donor_name ?? 'Anonymous' }}</td>
                            <td style="font-weight: 700;">₦{{ number_format($donation->amount, 2) }}</td>
                            <td>{{ $donation->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align: center; color: #94a3b8;">No donations yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">Recent Store Orders</h3>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td style="font-weight: 700;">₦{{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align: center; color: #94a3b8;">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
