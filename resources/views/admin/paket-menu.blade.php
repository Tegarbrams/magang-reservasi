<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Paket Menu - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-active {
            background: linear-gradient(135deg, #D4AF37 0%, #F4E5A1 100%);
            color: #000;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold text-yellow-500">NDALEM HANOMAN</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Dashboard</p>
            </div>

            <nav class="p-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Reservasi -->
                <a href="{{ route('admin.reservasi') }}"
                    class="{{ request()->routeIs('admin.reservasi') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Reservasi</span>
                </a>

                <!-- Kelola Jadwal -->
                <a href="{{ route('admin.schedule-management') }}"
                    class="{{ request()->routeIs('admin.schedule-management') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Kelola Jadwal</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase">Stok Management</p>
                </div>

                <!-- Paket Menu - ACTIVE -->
                <a href="{{ route('admin.paket-menu') }}"
                    class="{{ request()->routeIs('admin.paket-menu*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="font-medium">Paket Menu</span>
                </a>

                <!-- Ruangan -->
                <a href="{{ route('admin.ruangan') }}"
                    class="{{ request()->routeIs('admin.ruangan*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Ruangan</span>
                </a>

                <!-- Fasilitas -->
                <a href="{{ route('admin.fasilitas') }}"
                    class="{{ request()->routeIs('admin.fasilitas*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <span>Fasilitas</span>
                </a>

                <!-- Menu Tambahan -->
                <a href="{{ route('admin.menu-tambahan') }}"
                    class="{{ request()->routeIs('admin.menu-tambahan*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Menu Tambahan</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase">User Management</p>
                </div>
            </nav>

            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div
                        class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-black font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full mt-2 px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-sm font-medium transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Manajemen Paket Menu</h2>
                        <p class="text-sm text-gray-600">Kelola paket menu dan stok</p>
                    </div>
                    <button onclick="openAddModal()"
                        class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-lg transition">
                        + Tambah Paket Menu
                    </button>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($paketMenus as $paket)
                        <div class="col-md-4">
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                                <!-- ← TAMBAHKAN GAMBAR -->
                                <img src="{{ $paket->gambar ? asset($paket->gambar) : asset('img/paket1.jpg') }}"
                                    alt="{{ $paket->nama }}" class="w-full h-48 object-cover">

                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold text-gray-800">{{ $paket->nama }}</h3>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium {{ $paket->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            Stock: {{ $paket->stock }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {{ $paket->deskripsi ?? 'Tidak ada deskripsi' }}
                                    </p>
                                    <p class="text-2xl font-bold text-yellow-600 mb-4">
                                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                    </p>
                                    <div class="flex gap-2">
                                        <button
                                            onclick="openEditModal({{ $paket->id }}, '{{ $paket->nama }}', {{ $paket->harga }}, {{ $paket->stock }}, '{{ addslashes($paket->deskripsi ?? '') }}', '{{ $paket->gambar }}')"
                                            class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                            Edit
                                        </button>
                                        <button onclick="deletePaket({{ $paket->id }})"
                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-gray-500">
                            Belum ada paket menu. Klik tombol "Tambah Paket Menu" untuk menambahkan.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $paketMenus->links() }}
                </div>

            </main>

        </div>

    </div>

    <!-- Modal Add/Edit -->
    <div id="formModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-md w-full mx-4">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah Paket Menu</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="paketForm" method="POST" class="p-6 space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Paket</label>
                    <input type="text" name="nama" id="nama" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" name="harga" id="harga" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                    <input type="number" name="stock" id="stock" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
                </div>

                <!-- ← TAMBAHKAN INPUT GAMBAR -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Paket</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <div id="previewContainer" class="mt-2 hidden">
                        <img id="imagePreview" src="" alt="Preview"
                            class="w-32 h-32 object-cover rounded-lg">
                    </div>
                </div>

                <div class="flex gap-2 pt-4">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-lg transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Paket Menu';
            document.getElementById('paketForm').action = '{{ route('admin.paket-menu.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('nama').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('stock').value = '';
            document.getElementById('deskripsi').value = '';
            document.getElementById('formModal').classList.remove('hidden');
        }

        function openEditModal(id, nama, harga, stock, deskripsi, gambar) {
            document.getElementById('modalTitle').textContent = 'Edit Paket Menu';
            document.getElementById('paketForm').action = `/admin/paket-menu/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('nama').value = nama;
            document.getElementById('harga').value = harga;
            document.getElementById('stock').value = stock;
            document.getElementById('deskripsi').value = deskripsi;

            // ← TAMBAHKAN PREVIEW GAMBAR
            if (gambar) {
                document.getElementById('imagePreview').src = `/${gambar}`;
                document.getElementById('previewContainer').classList.remove('hidden');
            } else {
                document.getElementById('previewContainer').classList.add('hidden');
            }

            document.getElementById('formModal').classList.remove('hidden');
        }

        // ← TAMBAHKAN PREVIEW SAAT PILIH GAMBAR
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('previewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        function closeModal() {
            document.getElementById('formModal').classList.add('hidden');
        }

        function deletePaket(id) {
            if (!confirm('Yakin ingin menghapus paket menu ini?')) return;

            fetch(`/admin/paket-menu/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Paket menu berhasil dihapus');
                        location.reload();
                    } else {
                        alert('Gagal menghapus paket menu');
                    }
                });
        }
    </script>

</body>

</html>
