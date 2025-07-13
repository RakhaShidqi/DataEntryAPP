@extends('layouts.app')

@section('content')
<style>
    .info-box {
        background: #fff;
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
        height: 100%;
    }
    .info-box h6 {
        font-size: 0.9rem;
        color: #666;
    }
    .info-box p {
        font-size: 1.4rem;
        font-weight: bold;
        margin: 0;
        color: #333;
    }
    .card-section {
        background: #fff;
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
</style>
<div class="container-fluid">
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="info-box">
                <h6>Total Customer</h6>
                <p>{{ number_format($totalCustomers) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <h6>Total Subscribe</h6>
                <p>{{ number_format($totalSubscribers) }}</p>
            </div>
        </div>
        <!-- <div class="col-md-3">
            <div class="info-box">
                <h6>Purchase</h6>
                <p>+ 30,000</p>
            </div>
        </div> -->
        <div class="col-md-4">
            <div class="info-box">
                <h6>Income</h6>
                <p>Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <div class="card-section">
                <h6>Grafik Penjualan</h6>
                <canvas id="salesChart" height="150"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-section">
                <h6>Top Selling Products</h6>
                <canvas id="topProductChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card-section">
                <h6>Customer List</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Full Name</th><th>Email</th><th>Phone</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->fullname }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-section">
                <h6>Subscription List</h6>
                <table class="table table-sm">
                    <thead>
                        <tr><th>Customer Name</th><th>Subscription ID</th><th>Service Name</th><th>Installation ID</th><th>Monthly</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribes as $subscribe)
                            <tr>
                                <td>{{ $subscribe->customer->fullname ?? 'N/A' }}</td> <!-- Menampilkan nama customer -->
                                <td>{{ $subscribe->subscription_id }}</td>             <!-- ID langganan -->
                                <td>{{ $subscribe->service_name }}</td>                <!-- Nama layanan -->
                                <td>{{ $subscribe->installation_id }}</td>             <!-- ID pemasangan -->
                                <td>Rp{{ number_format($subscribe->monthly, 0, ',', '.') }}</td> <!-- Harga bulanan -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesChart = new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [
                {
                    label: 'Produk A',
                    data: [10, 20, 15, 18],
                    backgroundColor: '#FFD43B'
                },
                {
                    label: 'Produk B',
                    data: [12, 25, 20, 22],
                    backgroundColor: '#3B82F6'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const topProductChart = new Chart(document.getElementById('topProductChart'), {
        type: 'doughnut',
        data: {
            labels: ['Produk A', 'Produk B', 'Produk C'],
            datasets: [{
                data: [40, 30, 30],
                backgroundColor: ['#0d6efd', '#ffc107', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
