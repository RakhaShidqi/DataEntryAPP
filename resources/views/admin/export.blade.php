@extends('layouts.app')

@section('content')
<style>
    .export-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .export-header h3 {
        font-weight: 600;
    }
    .export-options {
        display: flex;
        gap: 1rem;
    }
</style>
<div class="container-fluid">
    <div class="export-header">
        <h3>Export Data</h3>
    </div>

    <div class="card p-4">
        <p class="mb-3">Silakan pilih jenis data yang ingin diekspor dan format ekspor yang diinginkan.</p>

        <form action="/export/process" method="POST">
            @csrf
            <div class="mb-3">
                <label for="data_type" class="form-label">Jenis Data</label>
                <select class="form-select" name="data_type" id="data_type" required>
                    <option value="customers">Customer</option>
                    <option value="subscriptions">Subscriptions</option>
                    <option value="logs">Log Activity</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="format" class="form-label">Format File</label>
                <select class="form-select" name="format" id="format" required>
                    <option value="excel">Excel (.xlsx)</option>
                    <option value="csv">CSV (.csv)</option>
                    <option value="pdf">PDF (.pdf)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Export Sekarang</button>
        </form>
    </div>
</div>
@endsection
