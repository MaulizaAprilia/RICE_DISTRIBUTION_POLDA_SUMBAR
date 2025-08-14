@extends('layout')

@section('title', 'Data Polres/ta')

@section('content')
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <div class="bg-white rounded-xl shadow-md p-6">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Data Polres/ta</h3>
                <a href="{{ route('superadmin.tambah.polres') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-white border border-green-600 text-green-600 hover:bg-green-50 font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition duration-200">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Data
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok Beras
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Distribusi
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($polres as $i => $m)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $polres->firstItem() + $i }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ ($m->stok_beras ?? 0) > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ is_null($m->stok_beras) ? '0 Kg' : $m->stok_beras . ' Kg' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ ($m->distribusi_beras ?? 0) > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ is_null($m->distribusi_beras) ? '0 Kg' : $m->distribusi_beras . ' Kg' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('superadmin.edit.polres', $m->id) }}"
                                            class="inline-flex items-center justify-center p-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                                            title="Edit Data">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <button onclick="confirmDelete({{ $m->id }})"
                                            class="inline-flex items-center justify-center p-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200"
                                            title="Hapus Data">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $m->id }}"
                                        action="{{ route('superadmin.hapus.polres', $m->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $polres->links() }}
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
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
