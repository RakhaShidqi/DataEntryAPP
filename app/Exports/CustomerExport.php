<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Customer::select('fullname', 'email', 'phone', 'status')->get();
    }

    public function headings(): array
    {
        return ['Full Name', 'Email', 'Phone', 'Status'];
    }
}
