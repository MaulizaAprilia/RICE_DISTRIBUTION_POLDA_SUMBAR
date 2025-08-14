@extends('layout')

@section('title', 'Dashboard Super Admin')

@section('content')

    {{-- <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition">
                    Filter
                </button>
            </div>

            <div class="flex items-end">
                <a href="{{ route('user.masyarakat') }}"
                    class="w-full px-4 py-2 bg-white border border-green-600 text-green-600 rounded-lg shadow hover:bg-green-50 focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition text-center">
                    Reset
                </a>
            </div>
        </form>
    </div> --}}
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Stok Tersedia</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">1,250 Kg</h2>
                    </div>
                    <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                        <i class="fas fa-warehouse text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Distribusi</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">1,250 Kg</h2>
                    </div>
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pesanan Baru</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">45</h2>
                    </div>
                    <div class="bg-green-100 text-green-600 rounded-full p-3">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                </div>
            </div> --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Masyarakat</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">189</h2>
                    </div>
                    <div class="bg-purple-100 text-purple-600 rounded-full p-3">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>
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
