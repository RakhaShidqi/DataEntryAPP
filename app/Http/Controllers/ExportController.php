<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Exports\SubscribeExport;
use App\Exports\LogExport;
use App\Models\Customer;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        // Jika ingin menampilkan data export di halaman index, bisa ganti isinya
        return view('admin.export'); // Jangan gunakan compact('export') jika tidak ada datanya
    }

    public function customers($format)
    {
        return $this->export(new CustomerExport, 'customers', $format);
    }

    public function subscribes($format)
    {
        return $this->export(new SubscribeExport, 'subscribes', $format);
    }

    public function logs($format)
    {
        return $this->export(new LogExport, 'logs', $format);
    }

    protected function export($export, $filename, $format)
    {
        if ($format === 'pdf') {
            // Ambil data dan header dari class export
            $data = $export->collection();
            $headers = $export->headings();

            return Pdf::loadView('exports.template', compact('data', 'headers'))
                ->download("{$filename}.pdf");
        }

        $excelFormat = match ($format) {
            'csv'  => \Maatwebsite\Excel\Excel::CSV,
            'xlsx' => \Maatwebsite\Excel\Excel::XLSX,
            default => abort(400, 'Format tidak didukung'),
        };

        return Excel::download($export, "{$filename}.{$format}", $excelFormat);
    }
}
