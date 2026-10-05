<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Parkir</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: #f0fdf9;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background blobs */
        body::before {
            content: '';
            position: fixed;
            top: -120px;
            left: -120px;
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -140px;
            right: -140px;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(5, 150, 105, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 16px;
            position: relative;
            z-index: 1;
        }

        /* Logo area above card */
        .login-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #0f766e 0%, #059669 100%);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(5, 150, 105, 0.35);
            margin-bottom: 14px;
        }

        .logo-icon svg {
            width: 40px;
            height: 40px;
        }

        .login-logo h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #064e3b;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .login-logo p {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 4px;
        }

        /* Card */
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04), 0 20px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.12);
            padding: 36px 32px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 28px;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
            pointer-events: none;
        }

        .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 11px 16px 11px 40px;
            font-size: 0.9rem;
            color: #111827;
            background-color: #fafafa;
            transition: all 0.2s ease;
            width: 100%;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .form-control::placeholder {
            color: #c4c9d4;
        }

        /* Toggle password */
        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .toggle-pass:hover {
            color: #10b981;
        }

        /* Login button */
        .btn-login {
            width: 100%;
            padding: 12px 24px;
            background: linear-gradient(135deg, #0f766e 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.35);
            background: linear-gradient(135deg, #0d6b64 0%, #047857 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Error alert */
        .alert-error {
            background-color: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #b91c1c;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 16px;
        }

        .alert-error li {
            margin-bottom: 2px;
        }

        /* Footer */
        .login-footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 0.8rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .login-footer-text i {
            color: #10b981;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- Logo -->
        <div class="login-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- P letter -->
                    <text x="36" y="72" font-family="Arial, sans-serif" font-size="66" font-weight="bold" fill="white"
                        text-anchor="middle">P</text>
                    <!-- Car silhouette -->
                    <rect x="50" y="66" width="22" height="7" rx="3" fill="white" opacity="0.85" />
                    <circle cx="54" cy="74" r="3.5" fill="white" opacity="0.85" />
                    <circle cx="68" cy="74" r="3.5" fill="white" opacity="0.85" />
                </svg>
            </div>
            <h2>Aplikasi Parkir</h2>
            <p>Sistem Manajemen Parkir Digital</p>
        </div>

        <!-- Card -->
        <div class="login-card">
            <p class="card-title">Selamat Datang 👋</p>
            <p class="card-subtitle">Masukkan akun Anda untuk melanjutkan</p>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="bi bi-exclamation-circle-fill" style="font-size:1rem; flex-shrink:0; margin-top:1px;"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="form-control" placeholder="contoh@email.com"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required>
                        <i class="bi bi-eye toggle-pass" id="togglePass"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
        </div>

        <div class="login-footer-text">
            <i class="bi bi-shield-check"></i>
            <span>Koneksi aman & terenkripsi</span>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle show/hide password
        const togglePass = document.getElementById('togglePass');
        const passwordInput = document.getElementById('password');
        togglePass.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>