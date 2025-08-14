<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Distribusi Beras</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        /* Custom styles untuk background image */
        .bg-rice-field {
            background-image: url('https://images.unsplash.com/photo-1621370215777-66a9d724773a?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>


<body class="bg-gray-100 flex items-center justify-center min-h-screen">
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
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-8 md:p-10 flex flex-col items-center mx-4 md:mx-0">

        <div class="mb-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-lime-600" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <h1 class="text-3xl font-bold text-gray-800 mt-2">Login Admin</h1>
            <p class="text-gray-500">Masuk untuk melanjutkan</p>
            @if (session('error'))
                <div class="w-full mb-1 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative"
                    role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.remove()">
                        ✖
                    </span>
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('login.admin.process') }}" class="w-full space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">username</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                    placeholder="superadmin" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
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
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                </div>
                {{-- <div class="text-sm">
                    <a href="#" class="font-medium text-lime-600 hover:text-lime-500">Lupa Password?</a>
                </div> --}}
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</body>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    function setupPasswordToggle(toggleButton, passwordInput) {
        toggleButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Mengganti ikon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    setupPasswordToggle(togglePassword, password);
</script>

</html>
