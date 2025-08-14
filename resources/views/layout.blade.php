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
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Overlay untuk menutup area di luar sidebar */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            /* di bawah sidebar (z-50) */
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            pointer-events: none;
        }

        .overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div id="overlay" class="overlay"></div>

    <div class="flex h-screen">
        <aside id="mobile-menu"
            class="bg-white w-64 p-4 shadow-lg fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex flex-col">

            <div class="flex justify-end md:hidden">
                <button id="close-btn" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="text-2xl font-bold text-lime-600 mb-6 mt-4">E-LAMBUANG</div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    @if (Auth::check() && Auth::user()->role == 'superadmin')
                        <li>
                            <a href="{{ route('superadmin.dashboard') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'dashboard' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }} ">
                                <i class="fas fa-home mr-3"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.akun.polres') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'akun' && request()->segment(3) == 'polres' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-users mr-3"></i> Akun Polres
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.akun.polsek') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'akun' && request()->segment(3) == 'polsek' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-users mr-3"></i> Akun Polsek
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.akun.user') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'akun' && request()->segment(3) == 'user' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-users mr-3"></i> Akun User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.polres') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'polres' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-building mr-3"></i> Polres/ta
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.polsek') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'polsek' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-shield-alt mr-3"></i> Polsek
                            </a>
                        </li>
                        {{-- <li><a href=""
                                class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200 {{ request()->segment(2) == 'masyarakat' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}"><i
                                    class="fas fa-users mr-3"></i>Masyarakat</a></li> --}}
                        <a href="{{ route('superadmin.ubah.password') }}"
                            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200 {{ request()->segment(3) == 'password' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                            <i class="fas fa-user mr-3"></i>Ubah Password
                        </a>
                    @endif
                    
                    @if (Auth::check() && Auth::user()->role == 'user')
                        <li><a href="{{ route('user.dashboard') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'dashboard' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }} "><i
                                    class="fas fa-home mr-3"></i>Dashboard</a></li>
                        <li><a href="{{ route('user.masyarakat') }}"
                                class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200 {{ request()->segment(2) == 'masyarakat' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}"><i
                                    class="fas fa-store mr-3"></i>Data Penjualan</a></li>
                        <a href="{{ route('user.profile') }}"
                            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200 {{ request()->segment(2) == 'profile' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                            <i class="fas fa-user mr-3"></i>Profile
                        </a>
                    @endif

                    @if (Auth::check() && Auth::user()->role == 'admin polsek')
                        <li>
                            <a href="{{ route('admin.polsek.dashboard') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'dashboard' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-home mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polsek.akun.user') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'akun-user' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-user mr-3"></i> Data User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.polsek.polsekpenjualan') }}"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-200 {{ request()->segment(2) == 'polsekpenjualan' ? 'bg-lime-100 text-lime-700 font-semibold' : '' }}">
                                <i class="fas fa-user mr-3"></i> Penjualan
                            </a>
                        </li>
                    @endif

                    {{-- <li><a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200"><i
                                class="fas fa-box-open mr-3"></i>Produk</a></li>
                    <li><a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200"><i
                                class="fas fa-clipboard-list mr-3"></i>Pesanan</a></li>

                    <li><a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200"><i
                                class="fas fa-chart-line mr-3"></i>Laporan</a></li>
                    <li> --}}

                    </li>
                </ul>
            </nav>
            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                        <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow p-4 flex justify-between items-center z-10">
                <button id="menu-btn"
                    class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h1 class="text-2xl font-bold text-gray-800 hidden md:block">Dashboard</h1>

            </header>
            @yield('content')
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
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
