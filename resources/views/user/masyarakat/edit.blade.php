@extends('layout')

@section('title', 'Edit Data Penjualan')

@section('content')
    <style>
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Pilih file';
            display: inline-block;
            background: #4B5563;
            color: white;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            outline: none;
            cursor: pointer;
            font-weight: 500;
            white-space: nowrap;
            user-select: none;
        }

        .custom-file-input:hover::before {
            background: #374151;
        }

        .custom-file-input:active::before {
            background: #1F2937;
        }
    </style>
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <div class="bg-white rounded-xl  overflow-x-hidden overflow-y-auto shadow-lg  w-full p-8 md:p-10">

            <div class="mb-8 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800">Edit Data Penjualan</h1>
                <p class="text-gray-500 mt-1">Edit penjualan beras untuk pendataan</p>
            </div>

            <form action="{{ route('user.update.masyarakat.process', $masyarakat->id) }}" class="space-y-6" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label for="jumlah-beras" class="block text-sm font-medium text-gray-700">Jumlah
                            Beras (dalam Kg)</label><input type="number" id="jumlah-beras" name="jumlah_beras"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                            placeholder="Contoh: 10" min="1" value="{{ $masyarakat->jumlah_beras }}" required>
                        @error('jumlah_beras')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="foto-ktp" class="block text-sm font-medium text-gray-700 mb-2">Foto
                        KTP</label>
                    <div id="dropzone"
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-lime-500 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48" aria-hidden="true">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m-4-4l-1.623 1.623a4 4 0 01-5.656 0L17.172 24.172"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex flex-col items-center text-sm text-gray-600">
                                <label for="foto-ktp"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-lime-600 hover:text-lime-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-lime-500">
                                    <span id="upload-text">Unggah file</span>
                                    <input id="foto_ktp_dropzone" name="foto_ktp" type="file" class="sr-only"
                                        accept="image/*">
                                </label>
                                <p class="mt-1 text-center">atau tarik dan letakkan</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 10MB</p>
                            <p id="file-name" class="text-xs text-gray-400 mt-2">Belum ada file yang
                                dipilih</p>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mt-2 text-sm text-gray-600">Foto KTP saat ini:</p>
                    <img src="{{ asset('uploads/ktp/' . $masyarakat->foto_ktp) }}" alt="Foto KTP"
                        class="w-50 h-auto rounded shadow mt-1">
                </div>
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>



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
