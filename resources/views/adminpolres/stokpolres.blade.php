@extends('layout')

@section('title', 'Stok Beras Polres')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">

    @php
        $unit = 'kg';
        $divider = 1;
        $labelUnit = ' Kg';
        // Ambil total stok sesuai polres_id yang login
        $totalStokAwalPolres = $data->sum('stok_awal');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Card Statistik --}}
        <div class="bg-blue-100 rounded-xl shadow-md p-6 flex flex-col justify-center items-center">
            <h4 class="text-sm font-medium text-gray-600">Total Stok Awal</h4>
            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ number_format($totalStokAwalPolres / $divider, 2) }}{{ $labelUnit }}
            </p>
        </div>

        {{-- Form Input --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <form method="POST" action="{{ route('admin.polres.stok.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Beras</label>
                    <input type="text" name="sumber_beras" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok Awal (Kg)</label>
                    <input type="number" name="stok_awal" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500" required>
                </div>

                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition w-full">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-md p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sumber Beras</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Awal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal & Jam</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($data as $i => $row)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $row->sumber_beras }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-500">{{ number_format($row->stok_awal / $divider, 2) }}{{ $labelUnit }}</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-500">{{ optional(\Carbon\Carbon::parse($row->created_at))->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
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