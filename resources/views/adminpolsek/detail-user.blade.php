@extends('layout')

@section('title', 'Detail User')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
    <a href="{{ route('admin.polsek.akun.user') }}"
        class="inline-flex items-center justify-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-gray-50">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="bg-white rounded-xl shadow-lg w-full p-8 md:p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-1 space-y-6">
                <div class="flex flex-col items-center p-6 border border-gray-200 rounded-xl bg-gray-50">
                    <div class="relative w-full max-w-xs h-0 pb-[100%] overflow-hidden rounded-full border-4 border-lime-500 shadow-md">
                        <img src="{{ $user->profile->foto_wajah ? asset('uploads/wajah/' . $user->profile->foto_wajah) : asset('uploads/wajah/default.jpg') }}"
                            alt="Foto Wajah" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mt-4">{{ $user->name }}</h2>
                    <span class="mt-2 text-gray-500 text-sm">NRP: {{ $user->profile->nrp }}</span>
                    <div class="mt-4">
                        @if ($user->is_approved == 1)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i> Belum Disetujui
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Dokumen Pendukung</h3>
                    <div class="relative w-full h-0 pb-[56.25%] overflow-hidden rounded-lg border-2 border-gray-300">
                        <img src="{{ $user->profile->foto_ktp ? asset('uploads/ktp/' . $user->profile->foto_ktp) : asset('uploads/ktp/default.jpg') }}"
                            alt="Foto KTP" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="md:col-span-1 space-y-6">
                <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi User</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pangkat</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->profile->pangkat }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $user->profile->jabatan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Wilayah Kerja</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                @if ($user->profile && $user->profile->polres)
                                    {{ $user->profile->polres->nama }}
                                    @if ($user->profile->polsek)
                                        - {{ $user->profile->polsek->nama }}
                                    @endif
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
