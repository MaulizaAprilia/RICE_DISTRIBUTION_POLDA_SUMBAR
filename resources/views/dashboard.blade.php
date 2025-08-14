<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Distribusi Beras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            pointer-events: none;
        }

        .overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Pilih file';
            display: inline-block;
            background: #4B5563;
            color: white;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            outline: none;
            cursor: pointer;
            font-weight: 500;
            white-space: nowrap;
            user-select: none;
        }

        .custom-file-input:hover::before {
            background: #374151;
        }

        .custom-file-input:active::before {
            background: #1F2937;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div id="overlay" class="overlay"></div>

    <div class="flex h-screen">

        <aside id="mobile-menu"
            class="bg-white w-64 p-4 shadow-lg fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex flex-col">
            <div class="flex justify-end md:hidden">
                <button id="close-btn" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="text-2xl font-bold text-lime-600 mb-6 mt-4">BerasKita</div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="#dashboard"
                            class="menu-item flex items-center p-3 rounded-lg bg-lime-100 text-lime-700 font-semibold">
                            <i class="fas fa-home mr-3"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#produk"
                            class="menu-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-box-open mr-3"></i>Produk
                        </a>
                    </li>
                    <li>
                        <a href="#pesanan"
                            class="menu-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-clipboard-list mr-3"></i>Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="#pelanggan"
                            class="menu-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-users mr-3"></i>Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="#profile"
                            class="menu-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-user-circle mr-3"></i>Profil
                        </a>
                    </li>
                    <li>
                        <a href="#laporan"
                            class="menu-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-chart-line mr-3"></i>Laporan
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-auto">
                <a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-sign-out-alt mr-3"></i>Keluar
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow p-4 flex justify-between items-center z-10">
                <button id="menu-btn"
                    class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h1 id="page-title" class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <div class="flex items-center space-x-4 ml-auto md:ml-0">
                    <button
                        class="bg-lime-600 text-white px-4 py-2 rounded-md hover:bg-lime-700 transition duration-150 ease-in-out hidden md:inline-block">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </button>
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=User" alt="User Profile"
                            class="w-10 h-10 rounded-full border-2 border-lime-500 cursor-pointer">
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 scrollbar-hide">
                <div id="content-container">
                    <div id="dashboard-content" class="page-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Penjualan</p>
                                        <h2 class="text-3xl font-bold text-gray-800 mt-1">Rp 12,5 Jt</h2>
                                    </div>
                                    <div class="bg-blue-100 text-blue-600 rounded-full p-3"><i
                                            class="fas fa-dollar-sign text-2xl"></i></div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Stok Tersedia</p>
                                        <h2 class="text-3xl font-bold text-gray-800 mt-1">1,250 Kg</h2>
                                    </div>
                                    <div class="bg-yellow-100 text-yellow-600 rounded-full p-3"><i
                                            class="fas fa-warehouse text-2xl"></i></div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Pesanan Baru</p>
                                        <h2 class="text-3xl font-bold text-gray-800 mt-1">45</h2>
                                    </div>
                                    <div class="bg-green-100 text-green-600 rounded-full p-3"><i
                                            class="fas fa-truck text-2xl"></i></div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                                        <h2 class="text-3xl font-bold text-gray-800 mt-1">189</h2>
                                    </div>
                                    <div class="bg-purple-100 text-purple-600 rounded-full p-3"><i
                                            class="fas fa-users text-2xl"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h3>
                                <a href="#" class="text-lime-600 hover:underline text-sm font-medium">Lihat
                                    Semua</a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No. Pesanan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pelanggan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #ORD001</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Budi Santoso
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">08/08/2025
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 150.000
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #ORD002</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Siti Rahayu
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07/08/2025
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 220.000
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #ORD003</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ahmad Faisal
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07/08/2025
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 95.000
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="profile-content" class="page-content hidden">
                        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-8 md:p-10">
                            <div class="mb-8 text-center md:text-left">
                                <h1 class="text-3xl font-bold text-gray-800">Profil Pengguna</h1>
                                <p class="text-gray-500 mt-1">Lengkapi data diri Anda untuk verifikasi akun.</p>
                            </div>
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div><label for="name" class="block text-sm font-medium text-gray-700">Nama
                                            Lengkap</label><input type="text" id="name" name="name"
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                                            placeholder="Contoh: Budi Santoso" required></div>
                                    <div><label for="nrp" class="block text-sm font-medium text-gray-700">NRP /
                                            NIP</label><input type="text" id="nrp" name="nrp"
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                                            placeholder="Contoh: 12345678" required></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div><label for="satuan-kerja"
                                            class="block text-sm font-medium text-gray-700">Satuan Kerja</label><input
                                            type="text" id="satuan-kerja" name="satuan-kerja"
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                                            placeholder="Contoh: Dinas Pertanian" required></div>
                                    <div><label for="pangkat"
                                            class="block text-sm font-medium text-gray-700">Pangkat</label><input
                                            type="text" id="pangkat" name="pangkat"
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                                            placeholder="Contoh: Letkol" required></div>
                                </div>
                                <div><label for="jabatan"
                                        class="block text-sm font-medium text-gray-700">Jabatan</label><input
                                        type="text" id="jabatan" name="jabatan"
                                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                                        placeholder="Contoh: Kepala Bagian" required></div>
                                <div>
                                    <label for="ktp-photo" class="block text-sm font-medium text-gray-700 mb-2">Foto
                                        KTP</label>
                                    <div class="flex items-center space-x-4">
                                        <input type="file" id="ktp-photo" name="ktp-photo"
                                            class="custom-file-input" accept="image/*" required>
                                        <span id="file-name" class="text-gray-500 text-sm">Belum ada file yang
                                            dipilih</span>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 ease-in-out">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // JavaScript untuk hamburger menu dan overlay
        const menuBtn = document.getElementById('menu-btn');
        const closeBtn = document.getElementById('close-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            mobileMenu.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }
        menuBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // JavaScript untuk ganti konten dan highlight menu
        const menuItems = document.querySelectorAll('.menu-item');
        const pageTitle = document.getElementById('page-title');
        const contentContainer = document.getElementById('content-container');
        const dashboardContent = document.getElementById('dashboard-content');
        const profileContent = document.getElementById('profile-content');
        const fileInput = document.getElementById('ktp-photo');
        const fileNameSpan = document.getElementById('file-name');

        // Fungsi untuk menampilkan konten yang sesuai
        function showPage(pageId) {
            // Sembunyikan semua konten
            document.querySelectorAll('.page-content').forEach(content => {
                content.classList.add('hidden');
            });
            // Tampilkan konten yang dipilih
            const currentPage = document.getElementById(pageId + '-content');
            if (currentPage) {
                currentPage.classList.remove('hidden');
                pageTitle.textContent = pageId.charAt(0).toUpperCase() + pageId.slice(1);
            }
        }

        // Fungsi untuk meng-highlight menu yang aktif
        function highlightMenuItem(targetItem) {
            menuItems.forEach(item => {
                item.classList.remove('bg-lime-100', 'text-lime-700', 'font-semibold');
                item.classList.add('text-gray-700', 'hover:bg-gray-200');
            });
            targetItem.classList.add('bg-lime-100', 'text-lime-700', 'font-semibold');
            targetItem.classList.remove('text-gray-700', 'hover:bg-gray-200');
        }

        // Event listener untuk setiap item menu
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const pageId = e.target.closest('a').getAttribute('href').substring(1);
                showPage(pageId);
                highlightMenuItem(e.target.closest('a'));
                if (window.innerWidth < 768) { // Tutup sidebar di mobile
                    toggleSidebar();
                }
            });
        });

        // Event listener untuk menampilkan nama file yang diunggah
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileNameSpan.textContent = e.target.files[0].name;
            } else {
                fileNameSpan.textContent = 'Belum ada file yang dipilih';
            }
        });

        // Tampilkan halaman dashboard saat pertama kali dimuat
        showPage('dashboard');
    </script>
</body>

</html>
