<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DashboardController;
use App\Exports\CustomerExport;
use App\Exports\SubscribesExport;
use App\Exports\LogActivityExport;
use Maatwebsite\Excel\Facades\Excel;


// Login
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register (jika ada)
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// ADMIN ONLY
Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth'])->name('admin.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth'])->name('user.dashboard');

// ✅ Customers Page
Route::get('/customers', [CustomerController::class, 'index'])->middleware('auth')->name('customers.index');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::delete('/customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('customers.bulkDelete');
Route::get('/customers/export', function () {
    return Excel::download(new CustomerExport, 'customers.xlsx');
})->name('customers.export');


// ✅ Subscribe Page
Route::get('/subscribes', [SubscribeController::class, 'index'])->middleware('auth')->name('subscribes.index');
Route::get('/subscribes', [SubscribeController::class, 'index'])->name('subscribes.index');
Route::post('/subscribes', [SubscribeController::class, 'store'])->name('subscribes.store');
Route::delete('/subscribes/bulk-delete', [SubscribeController::class, 'bulkDelete'])->name('subsribes.bulkDelete');
Route::get('/subscribes/export', function () {
    return Excel::download(new SubscribesExport, 'subscribes.xlsx');
})->name('subscribes.export');

// ✅ Log Activity Page
Route::get('/logs', [LogActivityController::class, 'index'])->name('logs.index');
Route::get('/logs/export', function () {
    return Excel::download(new LogActivityExport, 'LogActivity.xlsx');
})->name('Logs.export');

// ✅ Export Page & Process
Route::get('/export', [ExportController::class, 'index'])->middleware('auth')->name('export.index');
// Route::get('/export/customers/{format}', [ExportController::class, 'customers'])->name('export.customers');
// Route::get('/export/subscribes/{format}', [ExportController::class, 'subscribes'])->name('export.subscribes');
// Route::get('/export/logs/{format}', [ExportController::class, 'logs'])->name('export.logs');
// Route::post('/export/process', [ExportController::class, 'process'])->middleware('auth')->name('export.process');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

