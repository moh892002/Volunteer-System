<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('build/assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/bootstrap.min.css') }}">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
        }

        .login-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 400px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="login-card">
            <div class="text-center mb-4">
                <i class="fas fa-user text-primary brand-logo"></i>
                <h2 class="fw-bold mb-2">login Back</h2>
                <p class="text-muted mb-0">Please login to your account</p>
            </div>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <x-input name="email" label="Email" class="form-control mb-3" type="email" />
                <x-input name="password" label="Password" class="form-control mb-3" type="password" />
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('build/assets/js/all.js') }}"></script>
    <script src="{{ asset('build/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
