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

    // public function edit($id)
    // {
    //     $customer = Customer::findOrFail($id);
    //     return view('admin.customer-edit', compact('customer'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $customer = Customer::findOrFail($id);

    //     $validated = $request->validate([
    //         'fullname' => 'required|string|max:255',
    //         'email'    => 'required|email|unique:customers,email,' . $customer->id,
    //         'phone'    => 'required|string|max:20',
    //         'status'   => 'required|in:Active,Not Active',
    //     ]);

    //     $customer->update($validated);

    //     ActivityLog::create([
    //         'user'        => Auth::user()->name ?? 'Guest',
    //         'activity'    => 'Updated',
    //         'description' => 'Updated customer: ' . $customer->fullname,
    //         'timestamp'   => now(),
    //     ]);

    //     return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    // }

    // public function destroy($id)
    // {
    //     $customer = Customer::findOrFail($id);
    //     $name = $customer->fullname;
    //     $customer->delete();

    //     ActivityLog::create([
    //         'user'        => Auth::user()->name ?? 'Guest',
    //         'activity'    => 'Deleted',
    //         'description' => 'Deleted customer: ' . $name,
    //         'timestamp'   => now(),
    //     ]);

    //     return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    // }
}
