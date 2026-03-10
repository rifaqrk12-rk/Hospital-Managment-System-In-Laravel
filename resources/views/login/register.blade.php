<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bootstrap</title>
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

                <!-- card style me register form with icons -->
                <div class="card shadow-xl rounded-4 overflow-hidden">
                    <!-- header with icon -->
                    <div class="text-center pt-5 pb-3 px-4">
                        <H4>Register Now</H4>
                        <p class="text-muted">Join us today! Fill your details below</p>
                    </div>

                    <div class="card-body px-4 pb-5">

                        <!-- form start -->
                        <form method="post" action="{{ route('login-process') }}">
                            @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @csrf
                            <!-- name with icon -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Full Name">
                                </div>
                                @error('name')
                                <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- email with icon -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email address">
                                </div>
                                @error('email')
                                <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- password with icon -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control form-control-lg @error('password')is-invalid
                                    @enderror " placeholder="Password">
                                </div>
                                @error('password')
                                <span class="is-invalid">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- confirm password with icon -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password">
                                </div>

                            </div>

                            <!-- Phone with icon -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="number" name="phone" class="form-control form-control-lg" placeholder="Enter Phone">
                                </div>
                            </div>

                            <!-- address with icon -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="address" class="form-control form-control-lg" placeholder="Enter Address">
                                </div>
                            </div>

                            <!-- register button -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg fw-semibold py-3" type="submit">
                                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Register
                                </button>
                            </div>


                            <!-- already have account? -->
                            <div class="text-center mt-4">
                                <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: #764ba2;">Sign in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- card end -->

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>