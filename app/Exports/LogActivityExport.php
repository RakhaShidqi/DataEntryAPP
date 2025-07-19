<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogActivityExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ActivityLog::select('user', 'activity', 'description', 'timestamp')->get();
    }

    public function headings(): array
    {
        return ['User', 'Activity', 'Description', 'Timestamp'];
    }
}
