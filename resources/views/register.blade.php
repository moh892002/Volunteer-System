<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('build/assets/css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/css/bootstrap.min.css') }}" />
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .card-header {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        .register-icon {
            font-size: 3rem;
            color: #fff;
            background: #2575fc;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
            box-shadow: 0 4px 12px rgba(37, 117, 252, 0.2);
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-header bg- text-white text-center">
                    <div class="register-icon mb-2 p-5">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h4 class="mb-0 text-primary">Create Your Account</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('addUser') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}"
                                required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}"
                                required />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Create a password" required />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="Confirm your password" required />
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Already have an account?
                            <a href="{{ route('login') }}">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('build/assets/js/all.js') }}"></script>
    <script src="{{ asset('build/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
