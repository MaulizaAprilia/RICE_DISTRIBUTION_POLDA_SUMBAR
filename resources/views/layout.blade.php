<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Warna gradasi sama seperti login */
        .sidebar-gradient {
            background: linear-gradient(135deg, #15803d 0%, #65a30d 45%);
            color: white;
        }

        .sidebar-gradient a {
            color: white;
        }

        .sidebar-gradient a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar-gradient .active {
            background: rgba(255, 255, 255, 0.25);
            font-weight: bold;
        }

        /* Scrollbar hilang */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            pointer-events: none;
        }

        .overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .header-gradient {
            background:  #15803d 0%;
            color: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .header-gradient h1 {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .header-gradient button {
            color: white;
            transition: transform 0.2s ease;
        }

        .header-gradient button:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div id="overlay" class="overlay"></div>

    <div class="flex h-screen">
        <aside id="mobile-menu"
            class="sidebar-gradient w-64 p-4 shadow-lg fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex flex-col">

            <!-- Tombol Close -->
            <div class="flex justify-end md:hidden">
                <button id="close-btn" class="hover:text-yellow-200 focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Logo -->
            <div class="flex flex-col items-center mb-6 mt-4">
                <i class="fas fa-seedling text-4xl text-yellow-300 mb-2"></i>
                <span class="text-2xl font-bold text-yellow-300">E-LAMBUANG</span>
            </div>

            <!-- Menu -->
            <nav class="flex-1">
                <ul class="space-y-2">
                    @if (Auth::check() && Auth::user()->role == 'superadmin')
                        <li>
                            <a href="{{ route('superadmin.dashboard') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                                <i class="fas fa-home mr-3"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.akun.polres') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'akun' && request()->segment(3) == 'polres' ? 'active' : '' }}">
                                <i class="fas fa-users mr-3"></i> Akun Polres
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.akun.polsek') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'akun' && request()->segment(3) == 'polsek' ? 'active' : '' }}">
                                <i class="fas fa-users mr-3"></i> Akun Polsek
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.akun.user') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'akun' && request()->segment(3) == 'user' ? 'active' : '' }}">
                                <i class="fas fa-users mr-3"></i> Akun User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.polres') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'polres' ? 'active' : '' }}">
                                <i class="fas fa-building mr-3"></i> Polres/ta
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.polsek') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'polsek' ? 'active' : '' }}">
                                <i class="fas fa-shield-alt mr-3"></i> Polsek
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.ubah.password') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(3) == 'password' ? 'active' : '' }}">
                                <i class="fas fa-user mr-3"></i>Ubah Password
                            </a>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->role == 'user')
                        <li>
                            <a href="{{ route('user.dashboard') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                                <i class="fas fa-home mr-3"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.masyarakat') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'masyarakat' ? 'active' : '' }}">
                                <i class="fas fa-store mr-3"></i>Data Penjualan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'profile' ? 'active' : '' }}">
                                <i class="fas fa-user mr-3"></i>Profile
                            </a>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->role == 'admin polsek')
                        <li>
                            <a href="{{ route('admin.polsek.dashboard') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                                <i class="fas fa-home mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polsek.akun.user') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'akun-user' ? 'active' : '' }}">
                                <i class="fas fa-user mr-3"></i> Data User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polsek.polsekpenjualan') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'polsekpenjualan' ? 'active' : '' }}">
                                <i class="fas fa-store mr-3"></i> Penjualan
                            </a>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->role == 'admin polres')
                        <li>
                            <a href="{{ route('admin.polres.dashboard') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                                <i class="fas fa-home mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polres.userpolsek') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'akun-user' ? 'active' : '' }}">
                                <i class="fas fa-user mr-3"></i> User Polsek
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polres.polrespenjualan') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'polrespenjualan' ? 'active' : '' }}">
                                <i class="fas fa-store mr-3"></i> Penjualan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polres.stokpolres') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->segment(2) == 'stokpolres' ? 'active' : '' }}">
                                <i class="fas fa-store mr-3"></i> Stok Beras
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <!-- Tombol Logout -->
            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center p-3 rounded-lg hover:bg-red-500 hover:bg-opacity-70 transition">
                        <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        

        <!-- Main -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="header-gradient p-4 flex justify-between items-center z-10">
                <button id="menu-btn"
                    class="md:hidden focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-tachometer-alt text-yellow-300 text-2xl"></i>
                    <h1>@yield('title', 'Dashboard')</h1>
                </div>
            </header>
            @yield('content')
        </main>
    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const closeBtn = document.getElementById('close-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            mobileMenu.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }

        menuBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
</body>

</html>
