<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;

class FinancialRecordController extends Controller
{
    public function index()
    {
        $records = FinancialRecord::with('recordedBy')->latest('entry_date')->paginate(20);
        return view('admin.finance.ledger', compact('records'));
    }

    public function create()
    {
        $categories = [
            'income' => ['Tithe', 'Offering', 'Seed', 'Donation', 'Thanksgiving', 'Project Fund', 'Other'],
            'expense' => ['Salary', 'Utility', 'Rent', 'Maintenance', 'Evangelism', 'Honorarium', 'Other']
        ];
        return view('admin.finance.create_record', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        FinancialRecord::create([
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'entry_date' => $request->entry_date,
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.finance.ledger')->with('success', 'Record added successfully.');
    }

    public function destroy(FinancialRecord $record)
    {
        $record->delete();
        return back()->with('success', 'Record deleted successfully.');
    }
}
