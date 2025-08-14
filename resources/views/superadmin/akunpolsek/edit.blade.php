@extends('layout')

@section('title', 'Edit Akun Polsek')

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
                <h1 class="text-3xl font-bold text-gray-800">Edit Akun Polsek</h1>
            </div>

            <form action="{{ route('superadmin.edit.akun.polsek.process', $profile->user_id) }}" class="space-y-6"
                method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $profile->polsek_id }}" name="id_polsek">

                <div class="w-full ">
                    <label for="satker" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Polsek
                    </label>
                    <select id="satker" name="polsek_id" class="w-full py-2 rounded-md border border-gray-300 " required>
                        @if ($profile->polsek_id)
                            <option value="{{ $profile->polsek->id }}" selected>
                                {{ $profile->polsek->polres->nama }} - {{ $profile->polsek->nama }}
                            </option>
                        @endif
                    </select>
                    @error('polsek_id')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Username </label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                        placeholder="Contoh: polsekpadangtimur" value="{{ $user->name }}" required>
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <label for="password_new" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" id="password_new" name="password"
                        class="mt-1 block w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500">
                    <button type="button" id="togglePasswordNew"
                        class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-400">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <p class="text-[10px] text-red-500 mt-[-16px] ">kosongkan jika tidak ingin mengubah password</p>
                @error('password')
                    <p class="text-sm text-red-500 ">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                        Update Data
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
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

    <script>
        const togglePasswordNew = document.getElementById('togglePasswordNew');
        const passwordNew = document.getElementById('password_new');


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
    </script>

@endsection
