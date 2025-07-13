<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Models\Customer;

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
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_name' => 'required|string|max:255',
            'installation_id' => 'required|string|max:255',
            'subscription_id' => 'required|string|max:255',
            'monthly' => 'required|numeric',
        ]);

        Subscribe::create([
            'customer_id' => $request->customer_id,
            'service_name' => $request->service_name,
            'installation_id' => $request->installation_id,
            'subscription_id' => $request->subscription_id,
            'monthly' => $request->monthly,
        ]);

        return redirect()->route('subscribes.index')->with('success', 'Subscription berhasil ditambahkan.');
    }
}
