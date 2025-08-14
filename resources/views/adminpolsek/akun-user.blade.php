@extends('layout')

@section('title', 'Akun User')

@section('content')
<div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 mb-2 md:mb-0">Daftar Akun User</h3>
            <form id="search-form" method="GET" action="{{ route('admin.polsek.akun.user') }}" class="w-full md:w-auto">
                <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                    placeholder="Cari Nama, NRP, jabatan, atau pangkat..."
                    class="border rounded px-3 py-2 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-150"
                    autocomplete="off">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NRP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pangkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->profile->jabatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->profile->pangkat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.polsek.detail.user', $m->id) }}"
                                   class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
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

{{-- Optional: Search otomatis submit --}}
<script>
document.getElementById('search-input').addEventListener('input', function() {
    document.getElementById('search-form').submit();
});
</script>
@endsection
