@extends('layout')

@section('title', 'Detail Data Distribusi Beras')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">

    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.polres.polrespenjualan') }}"
        class="inline-flex items-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-green-50 transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    {{-- Card Informasi --}}
    <div class="bg-white rounded-xl shadow-lg w-full p-8 md:p-10 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-warehouse text-green-600 mr-3"></i> Detail Distribusi Beras
        </h2>

        {{-- Statistik Utama dalam 1 Baris --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Stok Awal --}}
            <div class="p-6 bg-green-50 border border-green-200 rounded-lg text-center shadow-sm">
                <div class="text-sm font-medium text-green-600">Stok Awal</div>
                <div class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($stokAwal, 2) }} Kg
                </div>
            </div>

            {{-- Jumlah Distribusi --}}
            <div class="p-6 bg-blue-50 border border-blue-200 rounded-lg text-center shadow-sm">
                <div class="text-sm font-medium text-blue-600">Jumlah Distribusi</div>
                <div class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($totalDistribusi, 2) }} Kg
                </div>
            </div>

            {{-- Sisa Stok --}}
            <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-center shadow-sm">
                <div class="text-sm font-medium text-yellow-600">Sisa Stok</div>
                <div class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($sisaStok, 2) }} Kg
                </div>
            </div>
        </div>

        {{-- Informasi Detail --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Nama Polres --}}
            <div class="p-5 rounded-lg bg-gray-50 border border-gray-200">
                <dt class="text-sm font-medium text-gray-500">Nama Polres</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $polsek->polres->nama ?? '-' }}
                </dd>
            </div>

            {{-- Nama Polsek --}}
            <div class="p-5 rounded-lg bg-gray-50 border border-gray-200">
                <dt class="text-sm font-medium text-gray-500">Nama Polsek</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $polsek->nama ?? '-' }}
                </dd>
            </div>

            {{-- Tanggal Distribusi --}}
            <div class="p-5 rounded-lg bg-gray-50 border border-gray-200">
                <dt class="text-sm font-medium text-gray-500">Tanggal Distribusi</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $detail->first() ? \Carbon\Carbon::parse($detail->first()->created_at)->translatedFormat('d F Y') : '-' }}
                </dd>
            </div>

            {{-- Waktu Distribusi --}}
            <div class="p-5 rounded-lg bg-gray-50 border border-gray-200">
                <dt class="text-sm font-medium text-gray-500">Waktu Distribusi</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $detail->first() ? \Carbon\Carbon::parse($detail->first()->created_at)->format('H:i') : '-' }}
                </dd>
            </div>
        </div>

        {{-- Tabel Distribusi User --}}
        <div class="bg-white rounded-xl shadow-md p-6 mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User Distributor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NRP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pangkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lampiran</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Beras</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal & Jam</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($detail as $i => $m)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->profile->nrp ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->profile->jabatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $m->user->profile->pangkat ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if ($m->foto_ktp)
                                    <img src="{{ asset('uploads/ktp/'.$m->foto_ktp) }}" class="h-16 w-auto rounded border">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-right text-gray-500">{{ $m->jumlah_beras }} Kg</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500">{{ \Carbon\Carbon::parse($m->created_at)->translatedFormat('d F Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $detail->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
