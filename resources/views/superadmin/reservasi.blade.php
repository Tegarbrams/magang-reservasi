<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reservasi - Super Admin</title>
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
                    class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="font-medium">Reservasi</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase">User Management</p>
                </div>

                <a href="{{ route('superadmin.admins') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Kelola Admin & User</span>
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
                        <h2 class="text-2xl font-bold text-gray-800">Data Reservasi</h2>
                        <p class="text-sm text-gray-600">Monitoring reservasi (Read Only)</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <form method="GET" action="{{ route('superadmin.reservasi') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Nama, nomor reservasi..." 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition">
                                🔍 Filter
                            </button>
                            <a href="{{ route('superadmin.reservasi') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition">
                                🔄 Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Total Pendapatan (DP Dibayar)</p>
                                <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Reservasi</p>
                                <p class="text-3xl font-bold mt-2">{{ $totalReservasiFiltered ?? 0 }}</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Filter Aktif</p>
                                <p class="text-3xl font-bold mt-2">
                                    {{ collect([request('status'), request('tanggal_mulai'), request('tanggal_akhir'), request('search')])->filter()->count() }}
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table READ-ONLY -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Reservasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket Menu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ruangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DP Dibayar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($reservasis as $reservasi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $reservasi->nomor_reservasi }}</td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $reservasi->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $reservasi->created_at->format('d M Y, H:i') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-gray-900">{{ $reservasi->no_hp }}</p>
                                            <p class="text-xs text-gray-500">{{ $reservasi->email }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $reservasi->paketMenu->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $reservasi->ruanganRel->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-green-600">Rp {{ number_format($reservasi->jumlah_dibayar ?? 0, 0, ',', '.') }}</p>
                                            <p class="text-xs text-gray-500">
                                                @if ($reservasi->tipe_pembayaran == 'dp_20') DP 20%
                                                @elseif($reservasi->tipe_pembayaran == 'dp_50') DP 50%
                                                @elseif($reservasi->tipe_pembayaran == 'full') Lunas
                                                @else - @endif
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                @if ($reservasi->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($reservasi->status == 'approved') bg-green-100 text-green-800
                                                @elseif($reservasi->status == 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($reservasi->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button onclick="viewDetail({{ $reservasi->id }})"
                                                class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg transition">
                                                👁️ Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">Tidak ada data reservasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $reservasis->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Detail (Read Only) -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-800">Detail Reservasi (Read Only)</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="p-6"></div>
        </div>
    </div>

    <script>
        function viewDetail(id) {
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('modalContent').innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-yellow-500 mx-auto"></div><p class="mt-4 text-gray-600">Memuat data...</p></div>';

            fetch(`/superadmin/reservasi/${id}/detail`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const r = data.data;
                    const formatRupiah = (num) => 'Rp ' + Number(num).toLocaleString('id-ID');
                    const formatTanggal = (date) => new Date(date).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    const tipePembayaranLabel = { 'dp_20': 'DP 20%', 'dp_50': 'DP 50%', 'full': 'Lunas (100%)' };

                    document.getElementById('modalContent').innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-4 rounded-lg">
                                    <p class="text-sm opacity-90">Nomor Reservasi</p>
                                    <p class="text-2xl font-bold">${r.nomor_reservasi}</p>
                                </div>
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-gray-800 mb-3">📋 Data Pemesan</h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between"><span class="text-gray-600">Nama</span><span class="font-medium">${r.nama}</span></div>
                                        <div class="flex justify-between"><span class="text-gray-600">Email</span><span class="font-medium">${r.email}</span></div>
                                        <div class="flex justify-between"><span class="text-gray-600">No. HP</span><span class="font-medium">${r.no_hp}</span></div>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-gray-800 mb-3">📅 Detail Reservasi</h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between"><span class="text-gray-600">Tanggal</span><span class="font-medium">${formatTanggal(r.tanggal)}</span></div>
                                        <div class="flex justify-between"><span class="text-gray-600">Jam</span><span class="font-medium">${r.jam}</span></div>
                                        <div class="flex justify-between"><span class="text-gray-600">Jumlah Orang</span><span class="font-medium">${r.jumlah_orang} orang</span></div>
                                        <div class="flex justify-between"><span class="text-gray-600">Paket</span><span class="font-medium">${r.paket_menu?.nama || '-'}</span></div>
                                        <div class="flex justify-between"><span class="text-gray-600">Ruangan</span><span class="font-medium">${r.ruangan?.nama || '-'}</span></div>
                                    </div>
                                </div>
                                ${r.catatan ? `<div class="border rounded-lg p-4"><h4 class="font-bold text-gray-800 mb-2">📝 Catatan</h4><p class="text-sm text-gray-700">${r.catatan}</p></div>` : ''}
                            </div>
                            <div class="space-y-4">
                                <div class="border rounded-lg p-4 bg-green-50">
                                    <h4 class="font-bold text-gray-800 mb-3">💰 Pembayaran</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center py-2 border-b">
                                            <span class="text-gray-600">Total</span>
                                            <span class="font-bold text-lg">${formatRupiah(r.total_harga)}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tipe</span>
                                            <span class="px-3 py-1 bg-yellow-500 text-white text-xs rounded-full">${tipePembayaranLabel[r.tipe_pembayaran] || r.tipe_pembayaran}</span>
                                        </div>
                                        <div class="flex justify-between py-2 bg-white rounded px-3">
                                            <span class="text-gray-600">DP Dibayar</span>
                                            <span class="font-bold text-green-600">${formatRupiah(r.jumlah_dibayar || 0)}</span>
                                        </div>
                                        <div class="flex justify-between py-2 bg-white rounded px-3">
                                            <span class="text-gray-600">Sisa</span>
                                            <span class="font-bold ${r.sisa_pembayaran > 0 ? 'text-orange-600' : 'text-green-600'}">${formatRupiah(r.sisa_pembayaran || 0)}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-gray-800 mb-3">🖼️ Bukti Pembayaran</h4>
                                    ${r.bukti_pembayaran ? `<img src="/storage/${r.bukti_pembayaran}" alt="Bukti" class="w-full rounded border-2 cursor-pointer hover:border-yellow-500" onclick="window.open(this.src, '_blank')">` : '<p class="text-gray-500 text-center py-4">Tidak ada bukti</p>'}
                                </div>
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <h4 class="font-bold text-gray-800 mb-2">📊 Status</h4>
                                    <span class="px-4 py-2 rounded-full text-sm font-medium inline-block
                                        ${r.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ''}
                                        ${r.status === 'approved' ? 'bg-green-100 text-green-800' : ''}
                                        ${r.status === 'rejected' ? 'bg-red-100 text-red-800' : ''}
                                        ${r.status === 'cancelled' ? 'bg-gray-100 text-gray-800' : ''}">
                                        ${r.status.toUpperCase()}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</body>
</html>