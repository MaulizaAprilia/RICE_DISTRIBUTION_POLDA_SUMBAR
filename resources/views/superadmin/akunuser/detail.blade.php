@extends('layout')

@section('title', 'Detail User')

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
        <a href="{{ route('superadmin.akun.user') }}"
            class="inline-flex items-center justify-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>

        <div class="bg-white rounded-xl shadow-lg w-full p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-1 space-y-6">
                    <div class="flex flex-col items-center p-6 border border-gray-200 rounded-xl bg-gray-50">
                        <div
                            class="relative w-full max-w-xs h-0 pb-[100%] overflow-hidden rounded-full border-4 border-lime-500 shadow-md">
                            <img src="{{ $users->profile->foto_wajah
                                ? asset('uploads/wajah/' . $users->profile->foto_wajah)
                                : asset('uploads/wajah/default.jpg') }}"
                                alt="Foto Wajah" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mt-4">{{ $users->name }}</h2>
                        <span class="mt-2 text-gray-500 text-sm">NRP: {{ $users->profile->nrp }}</span>
                        <div class="mt-4">
                            @if ($users->is_approved == 1)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Disetujui
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Belum Disetujui
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Dokumen Pendukung</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div
                                class="relative w-full h-0 pb-[56.25%] overflow-hidden rounded-lg border-2 border-gray-300">
                                <img src="{{ $users->profile->foto_ktp
                                    ? asset('uploads/ktp/' . $users->profile->foto_ktp)
                                    : asset('uploads/ktp/default.jpg') }}"
                                    alt="Foto KTP" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1 space-y-6">
                    <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi User</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pangkat</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $users->profile->pangkat }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $users->profile->jabatan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Satuan Kerja</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">
                                    @if ($users->profile && $users->profile->polres)
                                        {{ $users->profile->polres->nama }}
                                        @if ($users->profile->polsek)
                                            - {{ $users->profile->polsek->nama }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>
                        <div class="flex flex-col space-y-3">
                            @if ($users->is_approved == 0)
                                <form id="approve-form-{{ $users->id }}"
                                    action="{{ route('superadmin.setujui.user', $users->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <button onclick="confirmApprove({{ $users->id }})"
                                    class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                    <i class="fas fa-check mr-2"></i> Setujui Akun
                                </button>
                            @else
                                <form id="batal-form-{{ $users->id }}"
                                    action="{{ route('superadmin.setujui.user', $users->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <button onclick="confirmBatal({{ $users->id }})"
                                    class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                    <i class="fas fa-times mr-2"></i> Batal Setujui Akun
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmApprove(id) {
            Swal.fire({
                title: 'Yakin ingin menyetujui akun ini?',
                text: "Data ini bisa diubah kembali nanti jika diperlukan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745', // hijau
                cancelButtonColor: '#6b7280', // abu-abu
                confirmButtonText: 'Ya, setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-form-' + id).submit();
                }
            })
        }

        function confirmBatal(id) {
            Swal.fire({
                title: 'Yakin ingin batal menyetujui akun ini?',
                text: "Data ini bisa diubah kembali nanti jika diperlukan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // merah
                cancelButtonColor: '#6b7280', // abu-abu
                confirmButtonText: 'Ya, batal',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('batal-form-' + id).submit();
                }
            })
        }
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
