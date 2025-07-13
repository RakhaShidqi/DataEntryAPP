<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog; // pastikan model ini ada

class LogActivityController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderByDesc('timestamp')->get();
        return view('admin.log', compact('logs'));
    }
}
