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

    public function update(Request $request, $id)
    {
        // 1. Validasi input
        // Aturan 'unique' untuk email harus mengabaikan customer yang sedang diedit
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email,' . $id,
            'phone'    => 'required|string|max:20',
            'status'   => 'required|in:Active,Not Active',
        ]);

        try {
            // Memulai transaction untuk memastikan semua proses berhasil atau semua gagal
            DB::beginTransaction();

            // 2. Cari customer berdasarkan ID, jika tidak ketemu akan error
            $customer = Customer::findOrFail($id);

            // 3. Update data customer dengan data yang sudah divalidasi
            $customer->update($validated);

            // 4. Catat aktivitas update ke dalam log
            ActivityLog::create([
                'user'        => Auth::user()->name ?? 'Guest',
                'activity'    => 'Updated',
                'description' => 'Updated data for customer: ' . $customer->fullname,
                'timestamp'   => now(),
            ]);

            // 5. Konfirmasi transaction jika semua berhasil
            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer berhasil diupdate.');

        } catch (\Exception $e) {
            // Jika terjadi error, batalkan semua perubahan
            DB::rollBack();

            // Catat error untuk developer
            Log::error('Customer Update Failed: ' . $e->getMessage());

            // Kirim pesan error ke pengguna
            return back()->with('error', 'Gagal mengupdate data customer. Silakan coba lagi.');
        }
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