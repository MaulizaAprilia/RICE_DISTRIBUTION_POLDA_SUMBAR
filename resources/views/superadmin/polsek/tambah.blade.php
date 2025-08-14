@extends('layout')

@section('title', 'Tambah Polsek')

@section('content')

    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
        <a href="{{ route('superadmin.polsek') }}"
            class="inline-flex items-center justify-center px-4 py-2 mb-5 bg-white border border-green-600 text-green-600 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>

        <div class="bg-white rounded-xl  overflow-x-hidden overflow-y-auto shadow-lg  w-full p-8 md:p-10">

            <div class="mb-8 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Data Polsek</h1>
            </div>

            <form action="{{ route('superadmin.tambah.polsek.process') }}" class="space-y-6" method="post">
                @csrf

                <div class="relative">
                    <label for="polres" class="block text-sm font-medium text-gray-700">Polres/ta </label>

                    <select name="polres_id" id="polres-select" class="sr-only" required>
                        <option value="" disabled selected>Pilih Polres</option>
                        @foreach ($polres as $i => $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach


                    </select>

                    <div id="polres-custom-select" tabindex="0"
                        class="mt-1 relative flex items-center justify-between w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-all duration-200">
                        <span id="polres-selected-text" class="text-gray-500">Pilih Polres</span>
                        <svg id="polres-dropdown-arrow" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-400 transform transition-transform duration-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>

                    <div id="polres-menu" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg hidden">
                        <div class="py-1" role="menu" aria-orientation="vertical"
                            aria-labelledby="polres-custom-select">
                        </div>
                    </div>

                    @error('polres_id')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama </label>
                    <input type="text" id="nama" name="nama"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                        placeholder="Contoh: Polsek Padang Timur" required>
                    @error('nama')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                        Tambah Data
                    </button>
                </div>
            </form>
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
        // Pastikan kode ini berada di dalam tag <script> yang terpisah atau di akhir body
        const selectElementPolres = document.getElementById('polres-select');
        const customSelectPolres = document.getElementById('polres-custom-select');
        const selectedTextPolres = document.getElementById('polres-selected-text');
        const dropdownMenuPolres = document.getElementById('polres-menu');
        const dropdownArrowPolres = document.getElementById('polres-dropdown-arrow');

        // Mengisi menu kustom dengan opsi dari elemen select asli
        function populateCustomMenu() {
            dropdownMenuPolres.querySelector('div').innerHTML = '';
            selectElementPolres.querySelectorAll('option').forEach(option => {
                if (option.value) {
                    const menuItem = document.createElement('a');
                    menuItem.href = '#';
                    menuItem.className = 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100';
                    menuItem.textContent = option.textContent;
                    menuItem.setAttribute('role', 'menuitem');
                    menuItem.dataset.value = option.value;

                    menuItem.addEventListener('click', (e) => {
                        e.preventDefault();
                        selectOption(option.value, option.textContent);
                        toggleDropdown();
                    });

                    dropdownMenuPolres.querySelector('div').appendChild(menuItem);
                }
            });
        }

        // Mengatur opsi yang dipilih
        function selectOption(value, text) {
            selectElementPolres.value = value;
            selectedTextPolres.textContent = text;
            selectedTextPolres.classList.remove('text-gray-500');
            selectedTextPolres.classList.add('text-gray-900');
        }

        // Mengubah status dropdown (buka/tutup)
        function toggleDropdown() {
            dropdownMenuPolres.classList.toggle('hidden');
            dropdownArrowPolres.classList.toggle('rotate-180');
            customSelectPolres.classList.toggle('border-lime-500');
            customSelectPolres.classList.toggle('ring-2');
            customSelectPolres.classList.toggle('ring-offset-2');
            customSelectPolres.classList.toggle('ring-lime-500');
        }

        // Event listener untuk membuka/menutup dropdown
        customSelectPolres.addEventListener('click', toggleDropdown);
        customSelectPolres.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown();
            }
        });

        // Menutup dropdown saat klik di luar area
        document.addEventListener('click', (e) => {
            if (!customSelectPolres.contains(e.target) && !dropdownMenuPolres.contains(e.target)) {
                if (!dropdownMenuPolres.classList.contains('hidden')) {
                    toggleDropdown();
                }
            }
        });

        // Inisialisasi: Panggil fungsi untuk mengisi menu
        populateCustomMenu();
    </script>
@endsection
