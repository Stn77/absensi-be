<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            --smooth-in: cubic-bezier(.32, 0, .33, 1);
        }

        body {
            background-color: #F4F4F4;
        }

        .hero {
            /* height: 100vh; */
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .hero-img {
            animation: hero-img 600ms var(--smooth-in) 0ms 1;
        }

        .mini-star {
            position: absolute;
            transform: translate(-5px);
            animation: mini-star 5s infinite;
        }

        @keyframes hero-img {
            0% {
                transform: translateY(300px);
                opacity: 0;
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes mini-star {

            0%,
            100% {
                transform: rotate(20deg);
            }

            50% {
                transform: rotate(-10deg)
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="#">
            {{-- <img src="{{asset('assets/logo/Group 2 (1).png')}}" alt="Logo" width="30" height="30"
                class="d-inline-block align-text-top"> --}}
            Prima Score
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <div class="dropdown nav-item">
                    <button class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown button
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            {{-- <div class="d-flex">
                <a class="btn btn-primary text-light mx-2" href="{{route('login')}}">
                    Login
                </a>
                <a class="btn btn-outline-primary mx-2">
                    Regiter
                </a>
            </div> --}}
        </div>
    </nav>

    <div class="b-example-devider"></div>

    <section class="">
        <div class="px-4 pt-5 my-5 text-center border-bottom hero">
            <h1 class="display-4 fw-bold">
                <img src="{{asset('assets/img-assets/mini-items/star.png')}}" alt="" width="30" height="30"
                    class="mini-star"> Prima Score
            </h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Aplikasi monitor kehadiran siswa secara realtime dan akurat. Disertai juga beberapa
                    fitur pendukung untuk rekap absensi. </p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                    <a href="{{route('login')}}" type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Login</a>
                    {{-- <a href="" type="button" class="btn btn-outline-secondary btn-lg px-4">Secondary</a> --}}
                </div>
            </div>
            <div class="overflow-hidden">
                <div class="container px-5">
                    <img src="{{asset('assets/img-assets/Screenshot From 2025-11-06 09-36-08.png')}}"
                        class="hero-img img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700"
                        height="500" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">Daftar dan nikmati fitur yang tersedia</h1>
                <p class="col-lg-10 fs-4">Setelah anda daftar silahkan login dan Anda dapat menikmati fitur dan layanan
                    Prima Score</p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                <form class="p-4 p-md-5 border rounded-3 bg-light" id="registerForm"
                    action="{{route('register.submit')}}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Nama Lengkap" name="name" value="{{ old('name') }}">
                        <label for="name">Nama Lengkap</label>
                    </div>
                    <div class="form-floating mb-3">
                        @error('email')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="name@example.com" name="email" value="{{ old('email') }}">
                        <label for="email">Alamat Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        @error('password')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" name="password">
                        <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password_confirmation"
                            placeholder="Konfirmasi Password" name="password_confirmation">
                        <label for="password_confirmation">Konfirmasi Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Daftar</button>
                    <hr class="my-4">
                    <small class="text-muted">Dengan anda daftar, anda setuju dengan kebijakan dan layanan kami</small>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-body-secondary">© 2025 Company, Inc</p> <a href="/"
                class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"
                aria-label="Bootstrap"> <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg> </a>
            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
            </ul>
        </footer>
    </div>
</body>

</html>
