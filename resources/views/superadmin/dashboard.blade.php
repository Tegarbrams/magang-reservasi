<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin - Ndalem Hanoman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
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
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Dashboard Super Admin</h2>
                        <p class="text-sm text-gray-600">Monitoring & Overview (Read Only)</p>
                    </div>
                    <div class="text-sm text-gray-600">{{ now()->format('l, d F Y') }}</div>
                </div>
            </header>

            <!-- Content - SAMA SEPERTI ADMIN DASHBOARD -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Stats Cards Row 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Reservasi</p>
                                <h3 class="text-3xl font-bold text-gray-800">{{ $totalReservasi }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Pending</p>
                                <h3 class="text-3xl font-bold text-yellow-600">{{ $reservasiPending }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Approved</p>
                                <h3 class="text-3xl font-bold text-green-600">{{ $reservasiConfirmed }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Admin</p>
                                <h3 class="text-3xl font-bold text-purple-600">{{ $totalAdmin }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Reservasi -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Statistik Reservasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm opacity-90">Reservasi Hari Ini</p>
                                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-4xl font-bold">{{ $reservasiHariIni }}</h3>
                            <p class="text-sm mt-2 opacity-80">Total pemesanan hari ini</p>
                        </div>

                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm opacity-90">Reservasi Minggu Ini</p>
                                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-4xl font-bold">{{ $reservasiMingguIni }}</h3>
                            <p class="text-sm mt-2 opacity-80">7 hari terakhir</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm opacity-90">Reservasi Bulan Ini</p>
                                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-4xl font-bold">{{ $reservasiBulanIni }}</h3>
                            <p class="text-sm mt-2 opacity-80">Bulan berjalan</p>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">💰 Pendapatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
                            <p class="text-sm text-gray-600 mb-2">Hari Ini</p>
                            <h3 class="text-2xl font-bold text-emerald-600">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                            <p class="text-sm text-gray-600 mb-2">Minggu Ini</p>
                            <h3 class="text-2xl font-bold text-blue-600">Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                            <p class="text-sm text-gray-600 mb-2">Bulan Ini</p>
                            <h3 class="text-2xl font-bold text-purple-600">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
                            <p class="text-sm text-gray-600 mb-2">Total Pendapatan</p>
                            <h3 class="text-2xl font-bold text-yellow-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Charts & Status -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Reservasi 7 Hari Terakhir</h3>
                        <canvas id="reservasiChart"></canvas>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Status Reservasi</h3>
                        <canvas id="statusChart"></canvas>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">✅ Approved</span>
                                <span class="font-bold text-green-600">{{ $statusStats['approved'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">⏳ Pending</span>
                                <span class="font-bold text-yellow-600">{{ $statusStats['pending'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">❌ Rejected</span>
                                <span class="font-bold text-red-600">{{ $statusStats['rejected'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">🚫 Cancelled</span>
                                <span class="font-bold text-gray-600">{{ $statusStats['cancelled'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Pendapatan -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">💵 Pendapatan 4 Minggu Terakhir</h3>
                    <canvas id="pendapatanChart"></canvas>
                </div>

                <!-- Recent Reservasi -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Reservasi Terbaru</h3>
                    </div>
                    <div class="p-6">
                        @if ($recentReservasi->count() > 0)
                            <div class="space-y-4">
                                @foreach ($recentReservasi as $res)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $res->nama }}</p>
                                            <p class="text-sm text-gray-600">{{ $res->nomor_reservasi }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $res->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                @if ($res->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($res->status == 'approved') bg-green-100 text-green-800
                                                @elseif($res->status == 'cancelled') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($res->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Belum ada reservasi</p>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const reservasiCtx = document.getElementById('reservasiChart').getContext('2d');
        new Chart(reservasiCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($last7Days) !!},
                datasets: [{
                    label: 'Reservasi',
                    data: {!! json_encode($reservasiPerHari) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } }
            }
        });

        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Pending', 'Rejected', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $statusStats['approved'] }},
                        {{ $statusStats['pending'] }},
                        {{ $statusStats['rejected'] }},
                        {{ $statusStats['cancelled'] }}
                    ],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6b7280']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

        const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');
        new Chart(pendapatanCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($last4Weeks) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($pendapatanPerMinggu) !!},
                    backgroundColor: 'rgba(168, 85, 247, 0.8)',
                    borderColor: 'rgb(168, 85, 247)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>