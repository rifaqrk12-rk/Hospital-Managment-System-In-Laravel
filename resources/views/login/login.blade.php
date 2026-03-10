<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bootstrap</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: opacity 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-outline-primary {
            border: 2px solid #764ba2;
            color: #764ba2;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
        }

        .input-group-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5">

                <!-- Login Card -->
                <div class="card shadow-xl rounded-4 overflow-hidden">

                    <!-- Header with icon -->
                    <div class="text-center pt-5 pb-3 px-4">
                        <div class="bg-primary bg-gradient text-white rounded-circle d-inline-flex p-3 mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
                            <i class="fa-solid fa-right-to-bracket fa-2x"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #764ba2;">Welcome Back!</h3>
                        <p class="text-muted">Login to your account</p>
                    </div>

                    <!-- Login Form -->
                    <div class="card-body px-4 pb-4">

                        <form action="{{ route('loginnow') }}" method="get">
                            @if (session('success'))

                            <div class="alert alert-success">{{ session('success') }}</div>

                            @endif
                            @if (session('error'))

                            <div class="alert alert-success">{{ session('error') }}</div>

                            @endif
                            @csrf

                            <!-- Email or Username field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email or Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email"
                                        placeholder="Enter email or username"
                                        value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password field -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password"
                                        placeholder="Enter password">
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Buttons section - Login and Signup side by side -->
                            <div class="d-grid gap-3">
                                <!-- Login Button -->
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold py-3">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                                </button>

                                <!-- Divider with OR -->
                                <div class="position-relative my-2">
                                    <hr>
                                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">or</span>
                                </div>

                                <!-- Signup Button -->
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg fw-semibold py-3">
                                    <i class="fa-solid fa-user-plus me-2"></i>Create New Account
                                </a>
                            </div>


                        </form>
                    </div>
                </div>
                <!-- Card end -->

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>