<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Models\Customer;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function index()
    {
        $subscriptions = Subscribe::with('customer')->get();
        $customers = Customer::all();

        return view('admin.subscribes', compact('subscriptions', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_name' => 'required|string|max:255',
            'installation_id' => 'required|string|max:255',
            'subscription_id' => 'required|string|max:255',
            'monthly' => 'required|numeric',
        ]);

        $subsriptions = Subscribe::create($validated);

        Subscribe::create([
            'customer_id' => $request->customer_id,
            'service_name' => $request->service_name,
            'installation_id' => $request->installation_id,
            'subscription_id' => $request->subscription_id,
            'monthly' => $request->monthly,
        ]);

        return redirect()->route('subscribes.index')->with('success', 'Subscription berhasil ditambahkan.');
    }

    public function bulkDelete(Request $request)
{
    $ids = explode(',', $request->input('selected_ids'));

    if (empty($ids)) {
        return redirect()->back()->with('error', 'Tidak ada subscription yang dipilih untuk dihapus.');
    }

    $subscriptions = Subscribe::whereIn('id', $ids)->with('customer')->get();

    foreach ($subscriptions as $subscribe) {
        ActivityLog::create([
            'user'        => Auth::user()->name ?? 'Guest',
            'activity'    => 'Deleted',
            'description' => 'Deleted subscription for customer: ' . ($subscribe->customer->fullname ?? 'Unknown'),
            'timestamp'   => now(),
        ]);
    }

    Subscribe::whereIn('id', $ids)->delete();

    return redirect()->back()->with('success', 'Subscription yang dipilih berhasil dihapus.');
}
}
