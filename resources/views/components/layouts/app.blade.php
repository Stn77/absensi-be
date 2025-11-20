<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title ?? config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/dataTables.bootstrap5.min.css') }}">
    <style>
        /* Styling untuk sidebar responsif */
        .app-wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        .app-sidebar {
            min-height: 100vh;
            width: 280px;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.05), 0 2px 10px 0 rgba(0, 0, 0, 0.05);
        }

        .app-main {
            width: 100%;
            overflow-x: hidden;
            transition: all 0.3s;
        }

        /* Toggle button styling */
        .sidebar-toggle {
            display: none;
            top: 20px;
            left: 20px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 2px 10px;
            margin-right: 20px;
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Responsif untuk perangkat mobile */
        @media (max-width: 992px) {
            .app-sidebar {
                position: fixed;
                left: -280px;
                height: 100vh;
                overflow-y: auto;
            }

            .app-sidebar.active {
                left: 0;
            }

            .app-main {
                width: 100%;
            }

            .sidebar-toggle {
                display: block;
            }

            body.sidebar-open {
                overflow: hidden;
            }
        }
        .btn-toggle[aria-expanded="true"] {
            color: rgba(0, 0, 0, 0.85);
            z-index: 10;
        }

        .btn-toggle[aria-expanded="true"]::after {
            transform: rotate(90deg);
        }

        /* Sidebar styling */
        .app-sidebar {
            min-height: 100vh;
            width: 280px;
            transition: all 0.3s;
            z-index: 1000;
            /* background-color: #ffffff; */
            border-right: 1px solid #e2e8f0;
        }

        .sidebar-brand {
            padding: 1rem;
            text-align: center;
            /* border-bottom: 1px solid; */
        }

        .sidebar-content {
            height: calc(100vh - 80px);
            overflow-y: auto;
            padding: 0 0 1rem 0;
        }

        /* Menu utama */
        .crazy-nav {
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }

        .crazy-nav:hover {
            background-color: #f1f5f9;
            color: #2563EB;
        }

        .bg-active {
            background-color: #2563EB !important;
            color: #ffffff !important;
        }

        .bg-active:hover {
            background-color: #1D4ED8 !important;
            color: #ffffff !important;
        }

        /* Submenu */
        .btn-toggle {
            padding: 0.75rem 1rem;
            font-weight: 600;
            /* color: #475569; abu medium */
            background-color: transparent;
            border: 0;
            width: 100%;
            text-align: left;
        }

        .btn-toggle:hover,
        .btn-toggle:focus {
            color: #2563EB;
            background-color: #f8fafc;
        }

        .btn-toggle[aria-expanded="true"] {
            color: #2563EB;
            background-color: #f1f5f9;
        }

        .btn-toggle-nav a, .btn-toggle-nav .logout {
            padding: 0.5rem 1.5rem;
            margin-top: 0.125rem;
            margin-left: 1.25rem;
            font-size: 0.875rem;
            /* color: #475569; */
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-toggle-nav a:hover {
            background-color: #f1f5f9;
            /* color: #2563EB; */
        }

        .sub-nav-active {
            background-color: #10B981 !important; /* hijau aktif */
            color: #ffffff !important;
            border-radius: 5px;
        }
        .logout button:hover {
            background-color: #fee2e2; /* merah muda lembut */
            color: #b91c1c;
        }

        /* Style untuk notifikasi */
        #notification-area {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 350px;
        }

        .alert-auto-close {
            position: relative;
            overflow: hidden;
        }

        .alert-auto-close .progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(0,0,0,0.1);
        }

        .alert-auto-close .progress-bar {
            transition: width 2s linear;
        }
    </style>
    @stack('style')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Toggle Button untuk Mobile -->


        <!-- Overlay untuk Mobile -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar -->
        <aside class="app-sidebar {{$sidebarShow ?? 'd-block'}}">
            <div class="flex-shrink-0 p-3 d-flex flex-column h-100 bg-green-100">
                <div class="sidebar-brand">
                    <a href="/" class="brand-link">
                        <img src="{{ asset('assets/img/Prima Score.png') }}" alt="Logo" class="opacity-75 brand-image"
                            style="width: 150px;">
                    </a>
                </div>
                <div class="sidebar-content">

                    <ul class="mb-auto nav nav-pills flex-column">
                        @hasanyrole('admin')
                        <li class="nav-item my-1">
                            <a class="rounded navbar navbar-light btn ps-3 link-dark align-items-center w-100 text-start crazy-nav"
                                href="{{route('admin.dashboard')}}">
                                Scanner
                            </a>
                        </li>

                        <li class="nav-item my-1">
                            <a class="rounded navbar navbar-light btn ps-3 link-dark align-items-center w-100 text-start crazy-nav {{Route::is('admin.dashboard') ? 'bg-green-200 text-gray-100' : ''}}"
                                href="{{route('admin.dashboard')}}">
                                Scanner
                            </a>
                        </li>

                        <li class="nav-item my-1">
                            <a class="rounded navbar navbar-light btn ps-3 link-dark align-items-center w-100 text-start crazy-nav {{Route::is('admin.dashboard') ? 'bg-green-200 text-gray-100' : ''}}"
                                href="{{route('admin.dashboard')}}">
                                Scanner
                            </a>
                        </li>
                        @endhasanyrole
                    </ul>

                </div>
            </div>
        </aside>

        <div class="app-main">
            <div class="p-3 d-flex flex-column flex-grow-1">
                <div class="d-flex">
                    <button class="sidebar-toggle" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div class="app-content-header">
                        <h2 style="color: #303030;" class="{{$pageTitleName ?? 'd-block'}}">{{$pageTitleName ?? ''}}
                        </h2>
                    </div>
                </div>
                <div class="p-3 rounded shadow-sm app-content">
                    <div id="notification-area"></div>
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/jquery/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Fungsi untuk toggle sidebar di mode mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.app-sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.sidebar-overlay');
            const body = document.body;

            // Toggle sidebar ketika tombol diklik
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                body.classList.toggle('sidebar-open');
            });

            // Tutup sidebar ketika overlay diklik
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
            });

            // Tutup sidebar ketika item menu diklik di mode mobile
            if (window.innerWidth < 992) {
                const navLinks = document.querySelectorAll('.nav-link, .btn-toggle-nav a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                        body.classList.remove('sidebar-open');
                    });
                });
            }

            // Responsif ketika ukuran window berubah
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    body.classList.remove('sidebar-open');
                }
            });

            // Logout function

        });
    </script>
    <script>
        $('#logout').on('click', () => {
            const logoutConfirm = confirm('Apakah ingin Logout?')
            if(logoutConfirm){
                $.ajax({
                    type: 'POST',
                    url: '{{route('logout')}}',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        window.location.href = "{{route('login.page')}}"
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // This function is executed if the request fails
                        console.error("Error:", textStatus, errorThrown);
                    }
                });
            }
        });
    </script>
    <script>
        function showNotifCreate(message, type = 'success', duration = 5000){
            // Tentukan kelas alert berdasarkan type
            let alertClass;
            switch(type) {
                case 'success':
                    alertClass = 'alert-success';
                    break;
                case 'warning':
                    alertClass = 'alert-warning';
                    break;
                case 'error':
                    alertClass = 'alert-danger';
                    break;
                case 'info':
                default:
                    alertClass = 'alert-info';
                    break;
            }

            // Buat elemen notifikasi
            const notificationId = 'notif-' + Date.now();
            const notification = $(
                `<div id="${notificationId}" class="alert ${alertClass} alert-auto-close alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    ${message}
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>`
            );

            // Tambahkan notifikasi ke area notifikasi
            $('#notification-area').append(notification);

            // Animasikan progress bar
            setTimeout(function() {
                notification.find('.progress-bar').css('width', '0%');
            }, 10);

            // Hilangkan notifikasi setelah 2 detik
            setTimeout(function() {
                $('#' + notificationId).alert('close');
            }, duration);
        }
    </script>
    @stack('script')
</body>

</html>
