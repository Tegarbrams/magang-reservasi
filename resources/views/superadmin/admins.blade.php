<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Admin & User - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background: linear-gradient(135deg, #D4AF37 0%, #F4E5A1 100%); color: #000; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Super Admin -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold text-yellow-500">NDALEM HANOMAN</h1>
                <p class="text-xs text-gray-400 mt-1">Super Admin Dashboard</p>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('superadmin.reservasi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Reservasi</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase">User Management</p>
                </div>

                <a href="{{ route('superadmin.admins') }}"
                    class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium">Kelola Admin & User</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Super Admin</p>
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
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Admin & User</h2>
                        <p class="text-sm text-gray-600">Manajemen akses admin dan user biasa</p>
                    </div>
                    <button onclick="openAddModal()"
                        class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-lg transition">
                        ➕ Tambah Admin/User
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No HP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full {{ $user->role == 1 ? 'bg-blue-500' : 'bg-purple-500' }} flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->no_hp }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $user->role == 0 ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $user->role == 1 ? 'Admin' : 'User' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <button
                                                    onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->no_hp }}', {{ $user->role }})"
                                                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg transition">
                                                    ✏️ Edit
                                                </button>
                                                <button onclick="deleteUser({{ $user->id }})"
                                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg transition">
                                                    🗑️ Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada admin atau user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $users->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div id="formModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-md w-full mx-4">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah Admin/User</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="userForm" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1" id="passwordHelp">Minimal 6 karakter</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" id="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="0">User (Customer)</option>
                        <option value="1">Admin</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">⚠️ Super Admin tidak bisa dibuat dari sini</p>
                </div>

                <div class="flex gap-2 pt-4">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-lg transition">
                        💾 Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Admin/User';
            document.getElementById('userForm').action = '{{ route('superadmin.admins.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('no_hp').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password').required = true;
            document.getElementById('passwordHelp').textContent = 'Minimal 6 karakter';
            document.getElementById('role').value = '1';
            document.getElementById('formModal').classList.remove('hidden');
        }

        function openEditModal(id, name, email, no_hp, role) {
            document.getElementById('modalTitle').textContent = 'Edit Admin/User';
            document.getElementById('userForm').action = `/superadmin/admins/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('no_hp').value = no_hp;
            document.getElementById('password').value = '';
            document.getElementById('password').required = false;
            document.getElementById('passwordHelp').textContent = 'Kosongkan jika tidak ingin mengubah password';
            document.getElementById('role').value = role;
            document.getElementById('formModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('formModal').classList.add('hidden');
        }

        function deleteUser(id) {
            if (!confirm('⚠️ Yakin ingin menghapus user ini?\n\nData yang dihapus tidak dapat dikembalikan.')) return;

            fetch(`/superadmin/admins/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ User berhasil dihapus');
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Gagal menghapus user'));
                }
            })
            .catch(error => {
                alert('❌ Terjadi kesalahan: ' + error.message);
            });
        }
    </script>
</body>
</html>