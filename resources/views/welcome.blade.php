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
            height: 100vh;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light mx-3">
        <a class="navbar-brand" href="#">
            <img src="{{asset('assets/logo/Group 2 (1).png')}}" alt="Logo" width="30" height="30"
                class="d-inline-block align-text-top">
            Bootstrap
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <div class="d-flex">
                <a class="btn btn-primary text-light mx-2">
                    Login
                </a>
                <a class="btn btn-outline-primary mx-2">
                    Regiter
                </a>
            </div>
        </div>
    </nav>

    <div class="b-example-devider"></div>

    <section class="">
        <div class="px-4 pt-5 my-5 text-center border-bottom hero">
            <h1 class="display-4 fw-bold">
                <img src="{{asset('assets/img-assets/mini-items/star.png')}}" alt="" width="30" height="30"
                    class="mini-star"> Centered screenshot
            </h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the
                    world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive
                    grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                    <button type="button" class="btn btn-primary text-light btn-lg px-4 me-sm-3">Primary button</button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">Secondary</button>
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

    @if (config('app.env') !== 'production')
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    @else
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    @endif
</body>

</html>
