@extends('layout')

@section('title', 'Tambah Polres')

@section('content')

    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <a href="{{ route('superadmin.polres') }}"
            class="inline-flex items-center justify-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
        <div class="bg-white rounded-xl  overflow-x-hidden overflow-y-auto shadow-lg  w-full p-8 md:p-10">

            <div class="mb-8 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Data Polres/ta</h1>
            </div>

            <form action="{{ route('superadmin.tambah.polres.process') }}" class="space-y-6" method="post">
                @csrf

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama </label>
                    <input type="text" id="nama" name="nama" autofocus
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                        placeholder="Contoh: Polda Sumatera Barat" required>
                    @error('nama')
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
@endsection
