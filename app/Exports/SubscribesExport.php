<?php

namespace App\Exports;

use App\Models\Subscribe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscribesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Subscribe::with('customer')->get()->map(function ($sub) {
            return [
                'Customer Name'   => $sub->customer->fullname ?? '-',
                'Subscription ID' => $sub->subscription_id,
                'Service Name'    => $sub->service_name,
                'Installation ID' => $sub->installation_id,
                'Monthly'         => $sub->monthly,
            ];
        });
    }

    public function headings(): array
    {
        return ['Customer Name', 'Subscription ID', 'Service Name', 'Installation ID', 'Monthly'];
    }
}

