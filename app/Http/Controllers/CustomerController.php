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

        ActivityLog::create([
            'user'        => Auth::user()->name ?? 'Guest',
            'activity'    => 'Created',
            'description' => 'Added new customer: ' . $customer->fullname,
            'timestamp'   => now(),
        ]);

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

    public function bulkDelete(Request $request)
    {
    $ids = explode(',', $request->input('selected_ids'));

    if (empty($ids) || count($ids) === 0) {
        return redirect()->back()->with('error', 'Tidak ada customer yang dipilih untuk dihapus.');
    }

    $customers = Customer::whereIn('id', $ids)->get();

    foreach ($customers as $customer) {
        ActivityLog::create([
            'user'        => Auth::user()->name ?? 'Guest',
            'activity'    => 'Deleted',
            'description' => 'Deleted customer: ' . $customer->fullname,
            'timestamp'   => now(),
        ]);
    }

    Customer::whereIn('id', $ids)->delete();

    return redirect()->back()->with('success', 'Customer yang dipilih berhasil dihapus.');
}
}