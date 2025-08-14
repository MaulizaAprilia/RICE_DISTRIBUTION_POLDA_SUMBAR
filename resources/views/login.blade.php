<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-LAMBUANG</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        /* Gradasi hijau → kuning cerah */
        body {
            background: linear-gradient(135deg, #15803d 0%, #65a30d 45%, #b45309 100%);
        }

        .login-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .icon-padi {
            width: 90px;
            height: 90px;
        }

        /* Sawah samar */
        .sawah-bg {
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 120px;
            background-image: url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            pointer-events: none;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">
    @if (session('alert'))
        <script>
            Swal.fire({
                icon: '{{ session('alert.type') }}',
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.text') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <div class="login-card rounded-xl max-w-sm w-full p-8 md:p-10 flex flex-col items-center mx-4 md:mx-0">
        <div class="mb-6 text-center">
            <!-- Ikon Padi Baru -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon-padi mx-auto" viewBox="0 0 64 64">
                <g fill="#65a30d">
                    <path d="M32 2c-3 6-10 12-10 20 0 6 4 10 10 10s10-4 10-10c0-8-7-14-10-20z"/>
                    <path d="M22 38c-3 6-8 10-8 18h4c0-5 3-8 6-14 1-2 1-3-2-4z"/>
                    <path d="M42 38c3 6 8 10 8 18h-4c0-5-3-8-6-14-1-2-1-3 2-4z"/>
                </g>
                <ellipse cx="32" cy="56" rx="14" ry="6" fill="#a3e635"/>
            </svg>

            <h1 class="text-3xl font-bold text-lime-700 mt-2">E-LAMBUANG</h1>
            <p class="text-gray-600">Sistem Distribusi Beras Polda Sumbar</p>
        </div>

        <form method="POST" action="{{ route('login.process') }}" class="w-full space-y-6">
            @csrf
            <div>
                <label for="nrp" class="block text-sm font-medium text-gray-700">NRP</label>
                <input type="number" id="nrp" name="nrp"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                    placeholder="12345678" required>
                @error('nrp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                    placeholder="••••••••" required>
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-400">
                    <i class="fas fa-eye-slash"></i>
                </button>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                    Masuk
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-lime-600 hover:text-lime-500">Daftar sekarang</a>
        </p>

        <!-- Sawah samar -->
        <div class="sawah-bg"></div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
