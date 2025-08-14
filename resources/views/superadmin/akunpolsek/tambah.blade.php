@extends('layout')

@section('title', 'Tambah Akun Polsek')

@section('content')
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
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <a href="{{ route('superadmin.akun.polsek') }}"
            class="inline-flex items-center justify-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>

        <div class="bg-white rounded-xl  overflow-x-hidden overflow-y-auto shadow-lg  w-full p-8 md:p-10">

            <div class="mb-8 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Akun Polsek</h1>
            </div>

            <form action="{{ route('superadmin.tambah.akun.polsek.process') }}" class="space-y-6" method="POST">
                @csrf
                <div class="w-full ">
                    <label for="satker" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Polsek
                    </label>
                    <select id="satker" name="polsek_id" class="w-full py-2 rounded-md border border-gray-300 "
                        required></select>
                    @error('polsek_id')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Username </label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                        placeholder="Contoh: polsekpadangtimur" required>
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                        Tambah Data
                    </button>
                </div>
            </form>
        </div>
    </div>

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

    <script>
        $(document).ready(function() {
            $('#satker').select2({
                placeholder: 'Pilih Polsek',
                allowClear: true,
                ajax: {
                    url: '{{ route('api.polsek.search.lagi') }}',
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
    </script>
@endsection
