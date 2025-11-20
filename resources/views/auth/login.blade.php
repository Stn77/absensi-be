<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name') . ' Login'}}</title>
    @if (config('app.env') !== 'production')
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    @endif

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .form-section {
            padding: 3rem;
            background-color: white;
        }
        .logo-section {
            background: linear-gradient(135deg, #00A952 0%, #00D469 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 2rem;
        }
        .logo-section img {
            max-width: 250px;
            margin-bottom: 1.5rem;
        }
        .btn-login {
            background-color: #00D469;
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #00A952;
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #45FF8C;
            box-shadow: 0 0 0 0.2rem rgba(111, 90, 117, 0.25);
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
        .welcome-text {
            color: #6c757d;
            line-height: 1.6;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
            margin: 1.5rem 0;
        }
        @media (max-width: 768px) {
            .form-section {
                padding: 2rem;
            }
            .logo-section {
                padding: 1.5rem;
                min-height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center p-3">
        <div class="row login-container w-100" style="max-width: 1000px;">
            <!-- Left Section (Form) -->
            <div class="col-md-6 form-section">
                <h2 class="mb-3 fw-bold text-center text-md-start">Login</h2>
                <p class="mb-4 welcome-text text-center text-md-start">Selamat datang di Prima Score. Login untuk mengakses fitur Prima Score</p>

                <div class="divider"></div>

                <form id="loginForm" method="POST" action="{{route('login.submit')}}">
                    @csrf
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        @error('email')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
                        <div class="invalid-feedback">Harap masukkan email yang valid</div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        @error('password')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                        <div class="invalid-feedback">Harap masukkan password</div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login text-white w-100 py-3 fw-semibold mt-2">Login</button>

                    <!-- Register Link -->
                    {{-- <div class="text-center mt-4">
                        <p class="text-muted">Belum punya akun? <a href="#" class="text-decoration-none fw-semibold" style="color: #005828;">Daftar di sini</a></p>
                    </div> --}}
                </form>
            </div>

            <!-- Right Section (Logo) -->
            <div class="col-md-6 logo-section d-none d-md-flex">
                <h3 class="fw-bold mt-3">Prima Score</h3>
                <p class="text-center mt-2">Platform penilaian terpercaya untuk kebutuhan bisnis Anda</p>
            </div>
        </div>
    </div>

    @if (config('app.env') !== 'production')
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    @else
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    @endif

    <script>
        // Form validation
        // document.getElementById('loginForm').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     const email = document.getElementById('email');
        //     const password = document.getElementById('password');
        //     let isValid = true;

        //     // Reset validation states
        //     email.classList.remove('is-invalid');
        //     password.classList.remove('is-invalid');

        //     // Email validation
        //     if (!email.value || !isValidEmail(email.value)) {
        //         email.classList.add('is-invalid');
        //         isValid = false;
        //     }

        //     // Password validation
        //     if (!password.value) {
        //         password.classList.add('is-invalid');
        //         isValid = false;
        //     }

        //     if (isValid) {
        //         // Simulate login process
        //         const submitBtn = document.querySelector('.btn-login');
        //         const originalText = submitBtn.textContent;
        //         submitBtn.textContent = 'Memproses...';
        //         submitBtn.disabled = true;

        //         setTimeout(() => {
        //             alert('Login berhasil! (Ini hanya simulasi)');
        //             submitBtn.textContent = originalText;
        //             submitBtn.disabled = false;
        //         }, 1500);
        //     }
        // });

        function isValidEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    </script>
</body>
</html>
