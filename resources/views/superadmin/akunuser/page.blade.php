@extends('layout')

@section('title', 'Akun User')

@section('content')
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2 md:mb-0">Daftar Akun User</h3>
                <form id="search-form" method="GET" action="{{ route('superadmin.akun.user') }}" class="w-full md:w-auto">
                    <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                        placeholder="Cari nama user..."
                        class="border rounded px-3 py-2 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-150"
                        autocomplete="off">
                </form>
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
                                NRP
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $i => $m)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $users->firstItem() + $i }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->profile->nrp }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($m->is_approved == 1)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Belum Disetujui
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('superadmin.detail.user', $m->id) }}"
                                        class="inline-flex items-center justify-center p-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                                        title="Detail User">
                                        <i class="fas fa-info-circle text-sm"></i>
                                    </a>
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
                    {{ $users->links() }}
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
        const searchInput = document.getElementById('search-input');
        let timeout = null;

        searchInput.addEventListener('keyup', function() {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                document.getElementById('search-form').submit();
            }, 500);
        });
    </script>
@endsection
