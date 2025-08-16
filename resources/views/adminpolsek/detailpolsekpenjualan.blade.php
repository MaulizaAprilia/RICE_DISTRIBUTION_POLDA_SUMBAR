@extends('layout')

@section('title', 'Detail Data Penjualan')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
    <a href="{{ route('admin.polsek.polsekpenjualan') }}"
        class="inline-flex items-center justify-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-gray-50">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-lg w-full p-8 md:p-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Foto KTP --}}
            <div class="md:col-span-1 flex flex-col items-center">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Foto KTP / Wajah</h3>
                <div class="bg-gray-100 rounded-lg p-2 border-2 border-gray-300 w-full max-w-sm">
                    <img src="{{ asset('uploads/ktp/' . $masyarakat->foto_ktp) }}" alt="Foto KTP Masyarakat" class="w-full h-auto rounded-md">
                </div>
            </div>

            {{-- Detail Informasi --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Penerima</h3>
                <dl class="space-y-4">
                    {{-- Nama User --}}
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Distributor</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $masyarakat->user->name ?? '-' }}
                        </dd>
                    </div>

                    {{-- NRP --}}
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NRP</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $masyarakat->user->profile->nrp ?? '-' }}
                        </dd>
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $masyarakat->user->profile->jabatan ?? '-' }}
                        </dd>
                    </div>

                    {{-- Pangkat --}}
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Pangkat</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $masyarakat->user->profile->pangkat ?? '-' }}
                        </dd>
                    </div>

                    {{-- Jumlah Beras --}}
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah Beras (Kg)</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $masyarakat->jumlah_beras }} Kg</dd>
                    </div>

                    {{-- Tanggal Ditambahkan --}}
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Ditambahkan</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($masyarakat->created_at)->translatedFormat('d F Y H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
