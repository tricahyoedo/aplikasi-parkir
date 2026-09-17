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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
            background: white;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h3 {
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .login-header i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: block;
        }

        .login-body {
            padding: 40px 35px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 0.95rem;
            display: block;
        }

        .form-control {
            border: 1.5px solid #e0e6ed;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f8fafb;
        }

        .form-control:focus {
            border-color: #1e3c72;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.1);
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .btn-login {
            width: 100%;
            padding: 12px 24px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 60, 114, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert-error {
            background-color: #ffe5e5;
            border: 1.5px solid #ff6b6b;
            color: #cc0000;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert-error li {
            margin-bottom: 5px;
        }

        .login-footer {
            text-align: center;
            padding: 15px 35px;
            font-size: 0.85rem;
            color: #7f8c8d;
            background-color: #f8fafb;
            border-top: 1px solid #e0e6ed;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card">
        <div class="login-header">
            <i class="bi bi-p-square-fill"></i>
            <h3>Aplikasi Parkir</h3>
        </div>
        
        <div class="login-body">
            @if ($errors->any())
                <div class="alert-error">
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
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-lock-fill me-2"></i>Login
                </button>
            </form>
        </div>

        <div class="login-footer">
            <i class="bi bi-shield-check me-2"></i>Login Aman & Terenkripsi
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
