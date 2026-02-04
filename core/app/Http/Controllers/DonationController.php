<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function index()
    {
        return view('frontend.donate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $donation = Donation::create([
            'user_id' => auth()->id(),
            'donor_name' => $request->donor_name ?? auth()->user()?->name,
            'donor_email' => $request->donor_email ?? auth()->user()?->email,
            'amount' => $request->amount,
            'payment_method' => 'card',
            'transaction_ref' => 'DON-' . strtoupper(Str::random(10)),
            'status' => 'completed', // Simulated for now
            'note' => $request->note,
        ]);

        return redirect()->route('donate.thank-you')->with('donation', $donation);
    }

    public function thankYou()
    {
        return view('frontend.donate-thankyou');
    }
}
