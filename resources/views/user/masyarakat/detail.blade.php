@extends('layout')

@section('title', 'Detail Data Penjualan')

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


        <div class="bg-white rounded-xl shadow-lg w-full p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1 flex flex-col items-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Foto KTP / Wajah</h3>
                    <div class="bg-gray-100 rounded-lg p-2 border-2 border-gray-300 w-full max-w-sm">
                        <img src="{{ asset('uploads/ktp/' . $masyarakat->foto_ktp) }}" alt="Foto KTP Masyarakat"
                            class="w-full h-auto rounded-md">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Penerima</h3>
                    <dl class="space-y-4">

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jumlah Beras (Kg)</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $masyarakat->jumlah_beras }} Kg</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Ditambahkan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($masyarakat->created_at)->translatedFormat('d F Y H:i') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('user.edit.masyarakat', $masyarakat->id) }}"
                            class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i> Edit Data
                        </a>
                        <form id="delete-form-{{ $masyarakat->id }}"
                            action="{{ route('user.hapus.masyarakat.process', $masyarakat->id) }}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button onclick="confirmDelete({{ $masyarakat->id }})"
                            class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // merah
                cancelButtonColor: '#6b7280', // abu-abu
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form yang sesuai id
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
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
