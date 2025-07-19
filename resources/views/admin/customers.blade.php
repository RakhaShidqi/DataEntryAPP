@extends('layouts.app')

@section('content')
<style>
    .customer-header {
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
    <div class="customer-header">
        <h3>Customer</h3>
        <div>
            <!-- <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCustomerModal">Edit</a> -->
            <a href="#" id="btn-delete" class="btn btn-outline-danger">Delete</a>
            <a href="{{ route('customers.export') }}" class="btn btn-outline-primary">Export to Excel</a>
            <a href="#" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#addCustomerModal">+ New Customer</a>
        </div>
    </div>
    <form id="delete-form" method="POST" action="{{ route('customers.bulkDelete') }}">
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
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td><input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}"></td>
                        <td>{{ $customer->fullname }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            @if($customer->status === 'Active')
                                <span class="status-pill status-active">Active</span>
                            @else
                                <span class="status-pill status-inactive">Not Active</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

<!-- Modal Add Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Customer</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('customers.store') }}" method="PUT">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditCustomerModalLabel">Edit New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Customer</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!--  -->

<script>
    document.getElementById('btn-delete').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        const selected = [...checkboxes].map(cb => cb.value).filter(v => v !== 'on'); // skip header

        if (selected.length === 0) {
            alert("Pilih minimal satu customer untuk dihapus.");
            return;
        }

        if (confirm('Yakin ingin menghapus customer yang dipilih?')) {
            document.getElementById('selected_ids').value = selected.join(',');
            document.getElementById('delete-form').submit();
        }
    });
</script>
@endsection
