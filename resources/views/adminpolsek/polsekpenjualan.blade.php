@extends('layout')

@section('title', 'Data Penjualan User')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">

    {{-- Statistik & Filter/Search dalam 1 baris --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Card Statistik Total Beras --}}
        <div class="bg-green-100 rounded-xl shadow-md p-6 flex items-center justify-between w-full">
            <div>
                <h4 class="text-sm font-medium text-gray-600">Total Beras Didistribusikan</h4>
                <p id="total-beras" class="mt-2 text-2xl font-bold text-gray-800">
                    {{ $totalBeras ?? 0 }} Kg
                </p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="text-green-600 text-4xl">
                    <i class="fas fa-box"></i>
                </div>
                <button type="button" 
                    onclick="konversiKgTon()" 
                    class="px-3 py-1 bg-white text-green-600 border border-green-600 rounded-lg text-sm hover:bg-green-50 transition">
                    Konversi ke Ton
                </button>
            </div>
        </div>

        <script>
            function konversiKgTon() {
                const el = document.getElementById('total-beras');
                let text = el.innerText;
                let jumlah = parseFloat(text.replace(/[^0-9.]/g, ''));
                if (text.includes('Kg')) {
                    el.innerText = (jumlah / 1000).toFixed(2) + ' Ton';
                } else {
                    el.innerText = jumlah * 1000 + ' Kg';
                }
            }
        </script>

        {{-- Card Putih: Filter + Search + Cari --}}
        <div class="bg-white rounded-xl shadow-md p-6 md:col-span-2 flex flex-col justify-center">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                {{-- Dropdown Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter</label>
                    <select name="field"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
                        <option value="">-- Pilih Filter --</option>
                        <option value="name" {{ request('field') == 'name' ? 'selected' : '' }}>Nama User</option>
                        <option value="nrp" {{ request('field') == 'nrp' ? 'selected' : '' }}>NRP</option>
                        <option value="jabatan" {{ request('field') == 'jabatan' ? 'selected' : '' }}>Jabatan</option>
                        <option value="pangkat" {{ request('field') == 'pangkat' ? 'selected' : '' }}>Pangkat</option>
                        <option value="jumlah_beras" {{ request('field') == 'jumlah_beras' ? 'selected' : '' }}>Total Beras</option>
                    </select>
                </div>

                {{-- Input Search --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-green-500">
                </div>

                {{-- Tombol Cari --}}
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Filter Tanggal + Reset --}}
    <form method="GET" class="bg-white rounded-xl shadow-md p-6 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
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

        <div class="col-span-2 flex gap-2">
            <button type="submit"
                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition text-center">
                Filter
            </button>
            <a href="{{ route('admin.polsek.polsekpenjualan') }}"
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User Distributor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NRP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pangkat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lampiran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Beras</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal & Jam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($masyarakat as $i => $m)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $masyarakat->firstItem() + $i }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->profile->nrp ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->profile->jabatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->profile->pangkat ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if ($m->foto_ktp)
                                <a href="{{ asset('uploads/ktp/' . $m->foto_ktp) }}" data-fancybox="gallery">
                                    <img src="{{ asset('uploads/ktp/' . $m->foto_ktp) }}" class="h-15 w-auto rounded border">
                                </a>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $m->jumlah_beras }} Kg</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($m->created_at)->translatedFormat('d F Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.polsek.detailpolsekpenjualan', $m->id) }}"
                                class="px-4 py-2 bg-white border border-yellow-600 text-yellow-600 hover:bg-green-50 font-semibold rounded-lg shadow-sm transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $masyarakat->appends(request()->all())->links() }}
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
