@extends('layout')

@section('title', 'Ubah Password')

@section('content')

    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <div class="bg-white rounded-xl  overflow-x-hidden overflow-y-auto shadow-lg   w-full p-8 md:p-10">

            <div class="mb-8 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800">Ubah Password</h1>
            </div>

            <form action="{{ route('superadmin.ubah.password.process') }}" class="space-y-6" method="post">
                @csrf
                <div class="relative">
                    <label for="password_new" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" id="password_new" name="password"
                        class="mt-1 block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                        required>
                    <button type="button" id="togglePasswordNew"
                        class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-400">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-500 ">{{ $message }}</p>
                @enderror
                <div class="relative">
                    <label for="confirm_password_new" class="block text-sm font-medium text-gray-700">Konfirmasi Password
                        Baru</label>
                    <input type="password" id="confirm_password_new" name="password_confirmation"
                        class="mt-1 block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                        required>
                    <button type="button" id="toggleConfirmPasswordNew"
                        class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-400">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const togglePasswordNew = document.getElementById('togglePasswordNew');
        const passwordNew = document.getElementById('password_new');
        const toggleConfirmPasswordNew = document.getElementById('toggleConfirmPasswordNew');
        const confirmPasswordNew = document.getElementById('confirm_password_new');

        function setupPasswordToggle(toggleButton, passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Mengganti ikon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        setupPasswordToggle(togglePasswordNew, passwordNew);
        setupPasswordToggle(toggleConfirmPasswordNew, confirmPasswordNew);
    </script>
    <script>
        const fileInput = document.getElementById('foto_ktp_dropzone');
        const fileNameSpan = document.getElementById('file-name');
        const dropzone = document.getElementById('dropzone');

        // Mencegah perilaku default browser saat drag over dan drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Memberikan highlight visual saat file ditarik ke dalam dropzone
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropzone.classList.add('border-lime-500', 'bg-lime-50');
        }

        function unhighlight(e) {
            dropzone.classList.remove('border-lime-500', 'bg-lime-50');
        }

        // Menangani file yang dijatuhkan
        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            fileInput.files = files; // Assign file yang dijatuhkan ke input file
            updateFileName(files);
        }

        // Memperbarui nama file dari input file normal
        fileInput.addEventListener('change', (e) => {
            updateFileName(e.target.files);
        });

        function updateFileName(files) {
            if (files.length > 0) {
                fileNameSpan.textContent = files[0].name;
                fileNameSpan.classList.remove('text-gray-400');
                fileNameSpan.classList.add('text-gray-700', 'font-medium');
            } else {
                fileNameSpan.textContent = 'Belum ada file yang dipilih';
                fileNameSpan.classList.remove('text-gray-700', 'font-medium');
                fileNameSpan.classList.add('text-gray-400');
            }
        }

        // 👇 Tambahan kode baru di sini
        // Ketika dropzone diklik, picu event klik pada input file yang tersembunyi
        dropzone.addEventListener('click', () => {
            fileInput.click();
        });
    </script>
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
@endsection
