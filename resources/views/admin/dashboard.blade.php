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
        <div class="col-md-3">
            <div class="info-box">
                <h6>Total Customer</h6>
                <p>{{ number_format($totalCustomers) }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <h6>Total Subscribe</h6>
                <p>{{ number_format($totalSubscribers) }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <h6>Purchase</h6>
                <p>+ 30,000</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <h6>Income</h6>
                <p>+ 30,000</p>
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
                <h6>Stock Alert</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Order ID</th><th>Date</th><th>Quantity</th><th>Alert amt.</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>001</td><td>2025-07-13</td><td>3</td><td>Low</td><td>Pending</td></tr>
                        <tr><td>002</td><td>2025-07-12</td><td>2</td><td>Low</td><td>Pending</td></tr>
                        <tr><td>003</td><td>2025-07-11</td><td>4</td><td>Low</td><td>Pending</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-section">
                <h6>Top Selling Products</h6>
                <table class="table table-sm">
                    <thead>
                        <tr><th>Order ID</th><th>Quantity</th><th>Alert amt.</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>001</td><td>10</td><td>Normal</td></tr>
                        <tr><td>002</td><td>12</td><td>Normal</td></tr>
                        <tr><td>003</td><td>14</td><td>Normal</td></tr>
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
