@extends('layouts.app')

@section('content')
<style>
    .subscribes-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .customer-header h3 {
        font-weight: 600;
    }
    .btn-purple {
        background-color: #6f42c1;
        color: white;
    }
    .btn-purple:hover {
        background-color: #5a32a3;
    }
    .status-pill {
        padding: 0.3rem 1rem;
        border-radius: 20px;
        color: white;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-block;
    }
    .status-active {
        background-color: #28a745;
    }
    .status-inactive {
        background-color: #dc3545;
    }
    .search-bar {
        max-width: 300px;
        margin-bottom: 1rem;
    }
</style>
<div class="container-fluid">
    <div class="subscribes-header">
        <h3>Susbcription</h3>
        <div>
            <a href="#" class="btn btn-outline-warning">Edit</a>
            <a href="#" id="btn-delete" class="btn btn-outline-danger">Delete</a>
            <a href="{{ route('subscribes.export') }}" class="btn btn-outline-primary">Export to Excel</a>
            <!-- <a href="#" class="btn btn-outline-secondary">Import</a> -->
            <a href="#" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#subscriptionModal">+ New Subscription</a>
        </div>
    </div>
    <form id="delete-form" method="POST" action="{{ route('subsribes.bulkDelete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="selected_ids" id="selected_ids">
    </form>


    <div class="search-bar">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" placeholder="Search Customer ID">
        </div>
    </div>

    <div class="card p-3">
        <table class="table table-borderless align-middle">
            <thead class="border-bottom">
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Customer Name</th>
                    <th>Subscription ID</th>
                    <th>Service Name</th>
                    <th>Installation ID</th>
                    <th>Monthly</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscribe)
                    <tr>
                        <td><input type="checkbox" name="subscribe_ids[]" value="{{ $subscribe->id }}"></td>
                        <td>{{ $subscribe->customer->fullname ?? 'N/A' }}</td>
                        <td>{{ $subscribe->subscription_id }}</td>
                        <td>{{ $subscribe->service_name }}</td>
                        <td>{{ $subscribe->installation_id }}</td>
                        <td>Rp{{ number_format($subscribe->monthly, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('subscribes.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscriptionModalLabel">Add New Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer Name</label>
                    <select class="form-select" name="customer_id" required>
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subscription_id" class="form-label">Subscription ID</label>
                    <input type="text" class="form-control" name="subscription_id" required>
                </div>

                <div class="mb-3">
                    <label for="service_name" class="form-label">Service Name</label>
                    <input type="text" class="form-control" name="service_name" required>
                </div>

                <div class="mb-3">
                    <label for="installation_id" class="form-label">Installation ID</label>
                    <input type="text" class="form-control" name="installation_id" required>
                </div>

                <div class="mb-3">
                    <label for="monthly" class="form-label">Monthly Fee</label>
                    <input type="number" class="form-control" name="monthly" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Subscription</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
    document.getElementById('btn-delete').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        const selected = [...checkboxes].map(cb => cb.value).filter(v => v !== 'on'); // skip header

        if (selected.length === 0) {
            alert("Pilih minimal satu subscriptions untuk dihapus.");
            return;
        }

        if (confirm('Yakin ingin menghapus subscriptions yang dipilih?')) {
            document.getElementById('selected_ids').value = selected.join(',');
            document.getElementById('delete-form').submit();
        }
    });
</script>

@endsection
