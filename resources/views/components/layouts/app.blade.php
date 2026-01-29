<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title ?? config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('assets/css/poppins.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css"
        integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    {{--
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css"
        integrity="sha512-1k7mWiTNoyx2XtmI96o+hdjP8nn0f3Z2N4oF/9ZZRgijyV4omsKOXEnqL1gKQNPy2MTSP9rIEWGcH/CInulptA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    {{--
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
        integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            padding: 20px 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-text {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            width: 0;
        }

        .toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 4px solid #fff;
        }

        .menu-icon {
            width: 40px;
            font-size: 1.2rem;
            text-align: center;
            flex-shrink: 0;
        }

        .menu-text {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .menu-badge {
            margin-left: auto;
            background: #ff4757;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .sidebar.collapsed .menu-badge {
            display: none;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 600;
        }

        .user-info {
            overflow: hidden;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            transform: translateY(-70px);
        }

        .sidebar.collapsed~.main-content {
            margin-left: 80px;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-overlay.active {
            display: block;
        }

        .poni {
            margin: auto;
            width: 100vh;
            height: 75px;
            position: inherit;
            top: -2px;
            left: 2px;
            z-index: 1;
        }

        .mobile-menu-btn {
            display: none;
        }

        @media (max-width: 868px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 998;
                background: #1e3c72;
                color: white;
                border: none;
                width: 45px;
                height: 45px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            }

            .poni {
                left: 0px;
            }
        }

        .content-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            z-index: 2;
            color: #101110;
            transition: all 0.1s ease-in-out;
        }

        p {
            margin: 0;
        }

        .u-name {
            font-weight: 500;
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
    <link rel="stylesheet" href="{{asset('assets/css/custom-style.css')}}">
    @stack('style')
</head>

<body style="background-color: #f1fdfd;">
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <div class="brand-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="brand-text">Dashboard</span>
            </a>
            {{-- <button class="toggle-btn d-none d-md-block" onclick="toggleCollapse()">
                <i class="fas fa-bars"></i>
            </button> --}}
        </div>

        <ul class="sidebar-menu">
            <x-pieces.nav-button roleUser="admin|guru|siswa" link="dashboard" icon="home" name="Dashboard" />

            <x-pieces.nav-button roleUser="admin" link="admin.absensi.index" icon="calendar-alt" name="Absensi Siswa" />

            <x-pieces.nav-button roleUser="siswa" link="siswa.izin.create" icon="file-alt" name="Pengajuan Izin" />

            <x-pieces.nav-button roleUser="admin|siswa|guru" link="siswa.izin.list" icon="file-alt" name="Daftar Izin" />

            <x-pieces.sdbline />

            <x-pieces.nav-button roleUser="admin" link="data.siswa.index" icon="user" name="Akun Siswa" />


        </ul>

    </aside>

    <div class="poni bg-primary w-100">

    </div>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay d-lg-none" id="mobileOverlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="row content-card d-flex align-items-center justify-content-between mb-4">
            <div class="col-xl-4">
                <h2 class="poppins-light">{{ \App\Helpers\GreetingHelper::getGreeting() }} <span class="u-name poppins-bold">{{Auth::user()->name}}</span></h2>
            </div>
            <div class="col-xl-4 d-flex justify-content-end">
                <div class="dropdown">
                    <button class="p-2 bg-gray-500 rounded-circle" style="border:none; width: 3rem; height: 3rem;" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user fa-lg text-white rounded-circle"></i>
                    </button>
                    <ul class="dropdown-menu poppins-regular">
                        <li><a class="dropdown-item" href="{{route('profile.index')}}">Profile</a></li>
                        <li><button class="dropdown-item poppins-semibold" id="logout">Logout</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="notification-area"></div>
        {{$slot}}

    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function toggleCollapse() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

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
                        window.location.href = "{{route('login')}}"
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
