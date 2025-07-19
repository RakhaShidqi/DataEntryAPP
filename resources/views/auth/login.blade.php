<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Langganan Customer</title>
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
            max-width: 360px;
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
            <h5 class="mb-0">Login Data Entry</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <!-- Modal Error Login -->
                <div class="modal fade" id="loginErrorModal" tabindex="-1" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="loginErrorModalLabel">Login Gagal</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ session('login_error') }}
                    </div>
                    </div>
                </div>
                </div>

            <!-- <p class="mt-3 text-center small">Belum punya akun? <a href="/register">Daftar di sini</a></p> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            @if (session('login_error'))
        <script>
            const loginErrorModal = new bootstrap.Modal(document.getElementById('loginErrorModal'));
            loginErrorModal.show();
        </script>
        @endif
</body>
</html>
