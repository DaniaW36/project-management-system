<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NSRD Management</title>
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/soft-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        body {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .login-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0 2rem rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 100%;
        }
        .login-image {
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: white;
        }
        .login-image h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .login-image p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .login-form {
            padding: 2rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            height: 80px;
            margin-bottom: 1.5rem;
        }
        .login-header h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #344767;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            color: #67748e;
            font-size: 1rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #344767;
            margin-bottom: 0.5rem;
        }
        .form-control {
            height: 3rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            border: 1px solid #d2d6da;
            border-radius: 0.5rem;
            background-color: #fff;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #5e72e4;
            box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #d2d6da;
            border-right: none;
            color: #67748e;
        }
        .btn-login {
            height: 3rem;
            font-size: 0.875rem;
            font-weight: 600;
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
            border: none;
            border-radius: 0.5rem;
            color: white;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(94, 114, 228, 0.4);
        }
        .form-check {
            margin-bottom: 1.5rem;
        }
        .form-check-input {
            width: 1rem;
            height: 1rem;
            margin-top: 0.25rem;
        }
        .form-check-label {
            font-size: 0.875rem;
            color: #67748e;
        }
        .alert {
            border-radius: 0.5rem;
            font-size: 0.875rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #67748e;
            cursor: pointer;
            z-index: 10;
        }
        .footer-text {
            text-align: center;
            color: #67748e;
            font-size: 0.875rem;
            margin-top: 2rem;
        }
        @media (max-width: 991.98px) {
            .login-image {
                display: none;
            }
            .login-form {
                padding: 1.5rem;
            }
            body {
                overflow-y: auto;
            }
            .login-wrapper {
                height: auto;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="login-image">
                        <div class="text-center">
                            <h2>Welcome to NSRD</h2>
                            <p>Manage your projects and tasks efficiently</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-form">
                        <div class="login-header">
                            <img src="{{ asset('img/favicon.png') }}" alt="Logo">
                            <h3>Welcome Back!</h3>
                            <p>Enter your credentials to access your account</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="position-relative">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" id="password" 
                                               class="form-control" placeholder="Enter your password" required>
                                    </div>
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>

                            <div class="footer-text">
                                Don't have an account? Please contact your administrator.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
