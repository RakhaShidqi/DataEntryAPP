<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Entry App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background-color: #0056d2;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .logo {
            font-size: 1.3rem;
            font-weight: bold;
            padding: 1rem;
            background-color: #0041a8;
            text-align: center;
        }
        .sidebar a {
            color: white;
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #003e9f;
        }
        .logout {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }
        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <div class="logo">Data Entry</div>
            <a href="admin/dashboard" class="active"> 🏠 Dashboard</a>
            <a href="/customers">👤 Customer</a>
            <a href="/subscribes">📧 Subscribe</a>
            <a href="/logs"> 📄 Log Activity</a>
            <!-- <a href="/export">📤 Export</a> -->
        </div>
        <div class="logout">
            <a href="#" class="btn btn-dark btn-sm w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                Logout
            </a>
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Ya, Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
