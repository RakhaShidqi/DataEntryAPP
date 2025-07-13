<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Manajemen Langganan Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            padding: 1rem;
        }
        .card {
            width: 100%;
            max-width: 380px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
            border-radius: 12px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
        }
        .btn-primary {
            background-color: #0056d2;
            border: none;
        }
        .btn-primary:hover {
            background-color: #003e9f;
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header text-center">
            <h5 class="mb-0">Registrasi Akun</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/register">
                <!-- Tambahkan @csrf jika dalam Blade -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Daftar Sebagai</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
            <p class="mt-3 text-center small">Sudah punya akun? <a href="/login">Login di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
