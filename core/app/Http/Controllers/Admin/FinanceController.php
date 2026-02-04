<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Order;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $totalDonations = Donation::where('status', 'completed')->sum('amount');
        $totalOrders = Order::where('payment_status', 'paid')->sum('total_amount');
        
        // Manual Ledger Income
        $manualIncome = \App\Models\FinancialRecord::where('type', 'income')->sum('amount');
        
        // Manual Ledger Expenses
        $manualExpenses = \App\Models\FinancialRecord::where('type', 'expense')->sum('amount');

        $totalRevenue = $totalDonations + $totalOrders + $manualIncome;
        $netBalance = $totalRevenue - $manualExpenses;
        
        $recentDonations = Donation::where('status', 'completed')->latest()->take(5)->get();
        $recentOrders = Order::where('payment_status', 'paid')->latest()->take(5)->get();
        
        return view('admin.finance.index', compact(
            'totalDonations',
            'totalOrders',
            'totalRevenue',
            'netBalance',
            'manualIncome',
            'manualExpenses',
            'recentDonations',
            'recentOrders'
        ));
    }
}
