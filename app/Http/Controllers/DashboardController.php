<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Subscribe;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->take(5)->get(); // Ambil 5 data customer terbaru
        $totalCustomers = Customer::count();
        $subscribes = Subscribe::latest()->take(5)->get();
        $totalSubscribers = Subscribe::count();

        return view('admin.dashboard', compact('customers', 'subscribes', 'totalCustomers', 'totalSubscribers'));
    }
}
