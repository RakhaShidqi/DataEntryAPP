<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'required|string|max:20',
            'status'   => 'required|in:Active,Not Active',
        ]);

        $customer = Customer::create($validated);

        // Log aktivitas: tambah customer
        ActivityLog::create([
            'user'        => Auth::user()->name ?? 'Guest',
            'activity'    => 'Created',
            'description' => 'Added new customer: ' . $customer->fullname,
            'timestamp'   => now(),
        ]);

        // Log jika statusnya Active
        if ($customer->status === 'Active') {
            ActivityLog::create([
                'user'        => Auth::user()->name ?? 'Guest',
                'activity'    => 'Updated',
                'description' => 'Changed status of ' . $customer->fullname . ' to Active',
                'timestamp'   => now(),
            ]);
        }

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan.');
    }
}
