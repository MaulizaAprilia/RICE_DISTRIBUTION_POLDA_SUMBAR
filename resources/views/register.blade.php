<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Distribusi Beras</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-rice-field {
            background-image: url('https://images.unsplash.com/photo-1621370215777-66a9d724773a?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .select2-container--default .select2-selection--single {
            height: 40px;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: white;
            box-shadow: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            color: #374151;
            font-size: 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            right: 10px;
            color: #6b7280;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #84cc16;
            box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.3);
            outline: none;
        }

        .select2-dropdown {
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            font-size: 1rem;
        }

        .select2-results__option {
            padding: 0.5rem 1rem;
        }

        .select2-results__option--highlighted {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-8 md:p-10 flex flex-col items-center mx-4 md:mx-0">
        <div class="mb-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-lime-600" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <h1 class="text-3xl font-bold text-gray-800 mt-2">Daftar Akun Baru</h1>
            <p class="text-gray-500">Isi data diri Anda untuk memulai</p>
        </div>

        <form method="POST" action="{{ route('register.process') }}" class="w-full space-y-6"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="polres_id" id="polres_id">
            <input type="hidden" name="polsek_id" id="polsek_id">
            <div class="w-full max-w-sm">
                <label for="satker" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Satuan kerja
                </label>
                <select id="satker" name="polsek_id" class="w-full py-2 rounded-md border border-gray-300 "
                    required></select>
                @error('polsek_id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                    placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nrp" class="block text-sm font-medium text-gray-700">NRP</label>
                <input type="number" id="nrp" name="nrp"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                    placeholder="12345678" value="{{ old('nrp') }}" required>
                @error('nrp')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Pangkat</label>
                <input type="text" id="pangkat" name="pangkat"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                    placeholder="Masukkan nama Anda" value="{{ old('pangkat') }}" required>
                @error('pangkat')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                    placeholder="Masukkan nama Anda" value="{{ old('jabatan') }}" required>
                @error('jabatan')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Wajah
                </label>
                <div id="dropzone_wajah"
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-lime-500 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m-4-4l-1.623 1.623a4 4 0 01-5.656 0L17.172 24.172"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex flex-col items-center text-sm text-gray-600">
                            <label for="foto_wajah"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-lime-600 hover:text-lime-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-lime-500">
                                <span id="upload-text-wajah">Unggah file</span>
                                <input id="foto_wajah" name="foto_wajah" type="file" class="sr-only" accept="image/*"
                                    required>
                            </label>
                            <p class="mt-1 text-center">atau tarik dan letakkan</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, JPEG hingga 10MB
                        </p>
                        <p id="file-name-wajah" class="text-xs text-gray-400 mt-2">
                            Belum ada file yang dipilih
                        </p>
                    </div>
                </div>
                @error('foto_wajah')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto KTP
                </label>
                <div id="dropzone_ktp"
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-lime-500 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m-4-4l-1.623 1.623a4 4 0 01-5.656 0L17.172 24.172"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex flex-col items-center text-sm text-gray-600">
                            <label for="foto_ktp"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-lime-600 hover:text-lime-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-lime-500">
                                <span id="upload-text-ktp">Unggah file</span>
                                <input id="foto_ktp" name="foto_ktp" type="file" class="sr-only"
                                    accept="image/*" required>
                            </label>
                            <p class="mt-1 text-center">atau tarik dan letakkan</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, JPEG hingga 10MB
                        </p>
                        <p id="file-name-ktp" class="text-xs text-gray-400 mt-2">
                            Belum ada file yang dipilih
                        </p>
                    </div>
                </div>
                @error('foto_ktp')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                    placeholder="••••••••" required>
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-400">
                    <i class="fas fa-eye-slash"></i>
                </button>
                @error('password')
                    <p class="text-red-500 text-sm mt-1 ">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="mt-1 block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                    placeholder="••••••••" required>
                <button type="button" id="togglePasswordConfirmation"
                    class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-400">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>


            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                    Daftar
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-lime-600 hover:text-lime-500">Login sekarang</a>
        </p>
    </div>

</body>

<script>
    // --- JavaScript untuk Toggle Password ---
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmation = document.getElementById('password_confirmation');

    function setupPasswordToggle(toggleButton, passwordInput) {
        toggleButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    setupPasswordToggle(togglePassword, password);
    setupPasswordToggle(togglePasswordConfirmation, passwordConfirmation);

    // --- JavaScript untuk Select2 ---
    $(document).ready(function() {
        $('#satker').select2({
            placeholder: 'Pilih Satuan Kerja',
            allowClear: true,
            ajax: {
                url: '{{ route('api.polsek.search') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    }; // langsung pakai hasil API
                },
                cache: true
            }
        });
    });

    $('#satker').on('select2:select', function(e) {
        let data = e.params.data;

        // Isi hidden input
        $('#polres_id').val(data.polres_id);
        $('#polsek_id').val(data.polsek_id);
    });

    // --- JavaScript untuk Upload File (Foto Wajah) ---
    const fileInputWajah = document.getElementById('foto_wajah');
    const fileNameSpanWajah = document.getElementById('file-name-wajah');
    const dropzoneWajah = document.getElementById('dropzone_wajah');

    // Mengelola event drag-and-drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneWajah.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Memberikan highlight visual saat file ditarik
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzoneWajah.addEventListener(eventName, highlight, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropzoneWajah.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzoneWajah.classList.add('border-lime-500', 'bg-lime-50');
    }

    function unhighlight(e) {
        dropzoneWajah.classList.remove('border-lime-500', 'bg-lime-50');
    }

    // Menangani file yang dijatuhkan
    dropzoneWajah.addEventListener('drop', handleDropWajah, false);

    function handleDropWajah(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInputWajah.files = files;
        updateFileName(files, fileNameSpanWajah);
    }

    // Ketika dropzone diklik, picu input file
    dropzoneWajah.addEventListener('click', () => {
        fileInputWajah.click();
    });

    fileInputWajah.addEventListener('change', (e) => {
        updateFileName(e.target.files, fileNameSpanWajah);
    });

    // --- JavaScript untuk Upload File (Foto KTP) ---
    const fileInputKtp = document.getElementById('foto_ktp');
    const fileNameSpanKtp = document.getElementById('file-name-ktp');
    const dropzoneKtp = document.getElementById('dropzone_ktp');

    // Mengelola event drag-and-drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneKtp.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzoneKtp.addEventListener(eventName, highlightKtp, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropzoneKtp.addEventListener(eventName, unhighlightKtp, false);
    });

    function highlightKtp(e) {
        dropzoneKtp.classList.add('border-lime-500', 'bg-lime-50');
    }

    function unhighlightKtp(e) {
        dropzoneKtp.classList.remove('border-lime-500', 'bg-lime-50');
    }

    // Menangani file yang dijatuhkan
    dropzoneKtp.addEventListener('drop', handleDropKtp, false);

    function handleDropKtp(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInputKtp.files = files;
        updateFileName(files, fileNameSpanKtp);
    }

    // Ketika dropzone diklik, picu input file
    dropzoneKtp.addEventListener('click', () => {
        fileInputKtp.click();
    });

    fileInputKtp.addEventListener('change', (e) => {
        updateFileName(e.target.files, fileNameSpanKtp);
    });

    // --- Fungsi Pembantu untuk Upload File ---
    function updateFileName(files, spanElement) {
        if (files.length > 0) {
            spanElement.textContent = files[0].name;
            spanElement.classList.remove('text-gray-400');
            spanElement.classList.add('text-gray-700', 'font-medium');
        } else {
            spanElement.textContent = 'Belum ada file yang dipilih';
            spanElement.classList.remove('text-gray-700', 'font-medium');
            spanElement.classList.add('text-gray-400');
        }
    }
</script>

</html>
