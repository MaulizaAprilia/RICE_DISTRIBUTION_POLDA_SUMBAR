@extends('layout')

@section('title', 'POLRES - Data Distribusi Beras per Polsek')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">

    {{-- Filter Unit untuk Statistik --}}
    <form method="GET" action="{{ route('admin.polres.polrespenjualan') }}" class="mb-4 flex items-center gap-2">
        <label for="unit" class="text-sm font-medium text-gray-700">Tampilkan dalam:</label>
        <select name="unit" id="unit" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:border-green-500 focus:ring-green-500">
            <option value="kg" {{ request('unit') == 'kg' ? 'selected' : '' }}>Kilogram (Kg)</option>
            <option value="ton" {{ request('unit') == 'ton' ? 'selected' : '' }}>Ton</option>
        </select>
    </form>

    @php
        $unit = request('unit', 'kg');
        $divider = $unit === 'ton' ? 1000 : 1;
        $labelUnit = $unit === 'ton' ? ' Ton' : ' Kg';
        $stokSisa = $totalStokAwal - $totalDistribusi;
    @endphp

    {{-- Card Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- Stok Awal --}}
        <div class="bg-blue-100 rounded-xl shadow-md p-6 flex items-center justify-between w-full">
            <div>
                <h4 class="text-sm font-medium text-gray-600">Stok Awal Beras</h4>
                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ number_format($totalStokAwal / $divider, 2) }}{{ $labelUnit }}
                </p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-warehouse"></i>
            </div>
        </div>

        {{-- Total Distribusi --}}
        <div class="bg-green-100 rounded-xl shadow-md p-6 flex items-center justify-between w-full">
            <div>
                <h4 class="text-sm font-medium text-gray-600">Total Distribusi Beras</h4>
                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ number_format($totalDistribusi / $divider, 2) }}{{ $labelUnit }}
                </p>
            </div>
            <div class="text-green-600 text-4xl">
                <i class="fas fa-box"></i>
            </div>
        </div>

        {{-- Stok Sisa --}}
        <div class="bg-yellow-100 rounded-xl shadow-md p-6 flex items-center justify-between w-full">
            <div>
                <h4 class="text-sm font-medium text-gray-600">Stok Sisa</h4>
                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ number_format($stokSisa / $divider, 2) }}{{ $labelUnit }}
                </p>
            </div>
            <div class="text-yellow-600 text-4xl">
                <i class="fas fa-balance-scale"></i>
            </div>
        </div>
    </div>

    {{-- Filter Pencarian --}}
    <form method="GET" action="{{ route('admin.polres.polrespenjualan') }}" class="bg-white rounded-xl shadow-md p-6 mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter Kolom</label>
            <select name="field" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
                <option value="">-- Pilih Kolom --</option>
                <option value="nama" {{ request('field') == 'nama' ? 'selected' : '' }}>Nama Polsek</option>
                <option value="stok_beras" {{ request('field') == 'stok_beras' ? 'selected' : '' }}>Stok Awal</option>
                <option value="total_distribusi" {{ request('field') == 'total_distribusi' ? 'selected' : '' }}>Distribusi</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition text-center">
                Cari
            </button>
            <a href="{{ route('admin.polres.polrespenjualan') }}"
                class="flex-1 px-4 py-2 bg-white border border-green-600 text-green-600 rounded-lg shadow hover:bg-green-50 transition text-center">
                Reset
            </a>
        </div>
    </form>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-md p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Polsek</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Awal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Distribusi</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal dan Jam</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($data as $i => $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($row->stok_beras / $divider, 2) }}{{ $labelUnit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($row->total_distribusi / $divider, 2) }}{{ $labelUnit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $row->last_distribusi ? \Carbon\Carbon::parse($row->last_distribusi)->format('d F Y H:i') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <a href="{{ route('admin.polres.detailpolrespenjualan', $row->id) }}"
                                class="px-4 py-2 bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold rounded-lg shadow-sm transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
