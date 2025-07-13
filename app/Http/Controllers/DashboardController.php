<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Subscribe;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalSubscribers = Subscribe::count();

        return view('admin.dashboard', compact('totalCustomers', 'totalSubscribers'));
    }
}
