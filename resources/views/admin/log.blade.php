@extends('layouts.app')

@section('content')
<style>
    .log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .log-header h3 {
        font-weight: 600;
    }
    .search-bar {
        max-width: 300px;
        margin-bottom: 1rem;
    }
    .log-table td {
        vertical-align: middle;
    }
    .badge-action {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
        border-radius: 0.4rem;
    }
    .badge-create {
        background-color: #198754;
        color: white;
    }
    .badge-update {
        background-color: #ffc107;
        color: black;
    }
    .badge-delete {
        background-color: #dc3545;
        color: white;
    }
</style>
<div class="container-fluid">
    <div class="log-header">
        <h3>Log Activity</h3>
        <a href="#" class="btn btn-outline-primary">Download Log</a>
    </div>

    <div class="search-bar">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" placeholder="Search logs...">
        </div>
    </div>

    <div class="card p-3">
        <table class="table table-borderless align-middle">
            <thead class="border-bottom">
                <tr>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Description</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->user }}</td>
                        <td>
                            @if ($log->activity === 'Created')
                                <span class="badge bg-success">Created</span>
                            @elseif ($log->activity === 'Updated')
                                <span class="badge bg-warning text-dark">Updated</span>
                            @elseif ($log->activity === 'Deleted')
                                <span class="badge bg-danger">Deleted</span>
                            @endif
                        </td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->timestamp }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
