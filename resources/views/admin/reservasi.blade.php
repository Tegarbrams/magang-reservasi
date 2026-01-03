<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Reservasi - Admin</title>
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

        <!-- Sidebar (sama seperti sebelumnya) -->
       <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
    
    .luxury-title {
        font-family: 'Playfair Display', serif;
    }
    
    .sidebar-active { 
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        color: #000;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(255, 215, 0, 0.3);
    }
    
    .nav-item {
        transition: all 0.3s ease;
    }
    
    .nav-item:hover {
        background: rgba(255, 215, 0, 0.1);
        transform: translateX(5px);
    }
    
    .gold-accent {
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    }
</style>

<aside class="w-72 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex-shrink-0 shadow-2xl">
    
    <!-- Header Brand -->
    <div class="p-6 border-b-2 border-yellow-500/30">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 gold-accent rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-2xl">👑</span>
            </div>
            <div>
                <h1 class="luxury-title text-2xl font-bold text-yellow-400">NDALEM HANOMAN</h1>
                <p class="text-xs text-gray-400">Admin Dashboard</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 250px);">
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <span class="text-sm {{ request()->routeIs('admin.dashboard') ? '' : 'font-medium' }}">Dashboard</span>
        </a>

        <!-- Reservasi -->
        <a href="{{ route('admin.reservasi') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.reservasi') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.reservasi') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="text-sm {{ request()->routeIs('admin.reservasi') ? '' : 'font-medium' }}">Reservasi</span>
        </a>

        <!-- Kelola Jadwal -->
        <a href="{{ route('admin.schedule-management') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.schedule-management') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.schedule-management') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-sm {{ request()->routeIs('admin.schedule-management') ? '' : 'font-medium' }}">Kelola Jadwal</span>
        </a>

        <!-- Section Divider -->
        <div class="pt-6 pb-3">
            <div class="flex items-center gap-2 px-4">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-yellow-500/50 to-transparent"></div>
                <p class="text-xs font-semibold text-yellow-400 uppercase tracking-wider">Stok Management</p>
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-yellow-500/50 to-transparent"></div>
            </div>
        </div>

        <!-- Paket Menu -->
        <a href="{{ route('admin.paket-menu') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.paket-menu') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.paket-menu') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <span class="text-sm font-medium">Paket Menu</span>
        </a>

        <!-- Ruangan -->
        <a href="{{ route('admin.ruangan') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.ruangan') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.ruangan') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-sm font-medium">Ruangan</span>
        </a>

        <!-- Fasilitas -->
        <a href="{{ route('admin.fasilitas') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.fasilitas') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.fasilitas') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <span class="text-sm font-medium">Fasilitas</span>
        </a>

        <!-- Menu Tambahan -->
        <a href="{{ route('admin.menu-tambahan') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.menu-tambahan') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.menu-tambahan') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <span class="text-sm font-medium">Menu Tambahan</span>
        </a>

        <!-- Section Divider -->
        <div class="pt-6 pb-3">
            <div class="flex items-center gap-2 px-4">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-yellow-500/50 to-transparent"></div>
                <p class="text-xs font-semibold text-yellow-400 uppercase tracking-wider">User Management</p>
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-yellow-500/50 to-transparent"></div>
            </div>
        </div>

        {{-- Uncomment jika ada menu Data User
        <a href="{{ route('admin.users') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.users') ? 'sidebar-active' : '' }}">
            <div class="w-10 h-10 {{ request()->routeIs('admin.users') ? 'bg-white/20' : 'bg-gray-700' }} rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <span class="text-sm font-medium">Data User</span>
        </a>
        --}}
    </nav>

    <!-- User Profile & Logout (Fixed Bottom) -->
    <div class="absolute bottom-0 w-72 bg-gray-900/95 backdrop-blur p-4 border-t-2 border-yellow-500/30">
        <div class="flex items-center gap-3 px-4 py-3 bg-gray-800/50 rounded-xl mb-3">
            <div class="w-12 h-12 rounded-xl gold-accent flex items-center justify-center text-black font-bold shadow-lg text-lg">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-yellow-400">Administrator</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl text-sm font-semibold transition shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
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
                        <h2 class="text-2xl font-bold text-gray-800">Manajemen Reservasi</h2>
                        <p class="text-sm text-gray-600">Kelola semua reservasi pelanggan</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Enhanced Filters -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <form method="GET" action="{{ route('admin.reservasi') }}" id="filterForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <!-- Filter Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <!-- Filter Tanggal Mulai -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            </div>

                            <!-- Filter Tanggal Akhir -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            </div>

                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Nama, nomor reservasi..." 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('admin.reservasi') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Summary Card - Total Pendapatan -->
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

                <!-- Table -->
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-in</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DP Dibayar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($reservasis as $reservasi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $reservasi->nomor_reservasi }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $reservasi->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $reservasi->created_at->format('d M Y, H:i') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-gray-900">{{ $reservasi->no_hp }}</p>
                                            <p class="text-xs text-gray-500">{{ $reservasi->email }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $reservasi->paketMenu->nama ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $reservasi->ruanganRel->nama ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $reservasi->jam }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-green-600">
                                                Rp {{ number_format($reservasi->jumlah_dibayar ?? 0, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                @if ($reservasi->tipe_pembayaran == 'dp_20')
                                                    DP 20%
                                                @elseif($reservasi->tipe_pembayaran == 'dp_50')
                                                    DP 50%
                                                @elseif($reservasi->tipe_pembayaran == 'full')
                                                    Lunas
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <select onchange="updateStatus({{ $reservasi->id }}, this.value)"
                                                class="px-3 py-1 rounded-full text-xs font-medium border-0 cursor-pointer
                                                @if ($reservasi->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($reservasi->status == 'approved') bg-green-100 text-green-800
                                                @elseif($reservasi->status == 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                <option value="pending" {{ $reservasi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $reservasi->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $reservasi->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="cancelled" {{ $reservasi->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <button onclick="viewDetail({{ $reservasi->id }})"
                                                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg transition">
                                                    Detail
                                                </button>
                                                <button onclick="deleteReservasi({{ $reservasi->id }})"
                                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg transition">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-lg font-medium">Tidak ada data reservasi</p>
                                            <p class="text-sm mt-2">Coba ubah filter atau reset pencarian</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $reservasis->links() }}
                    </div>
                </div>

            </main>

        </div>

    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-800">Detail Reservasi</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="p-6">
                <!-- Content loaded dynamically -->
            </div>
        </div>
    </div>

    <script>
        function viewDetail(id) {
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('modalContent').innerHTML =
                '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-yellow-500 mx-auto"></div><p class="mt-4 text-gray-600">Memuat data...</p></div>';

            fetch(`/admin/reservasi/${id}/detail`, {
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
                        const formatTanggal = (date) => new Date(date).toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        const tipePembayaranLabel = {
                            'dp_20': 'DP 20%',
                            'dp_50': 'DP 50%',
                            'full': 'Lunas (100%)'
                        };

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
                            ${r.bukti_pembayaran ? `
                                <img src="/storage/bukti_pembayaran/${r.bukti_pembayaran}" alt="Bukti" class="w-full rounded border-2 cursor-pointer hover:border-yellow-500" onclick="window.open(this.src, '_blank')">
                                <a href="/storage/bukti_pembayaran/${r.bukti_pembayaran}" target="_blank" class="mt-3 block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">📥 Download / Lihat</a>
                            ` : '<p class="text-gray-500 text-center py-4">Tidak ada bukti</p>'}
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
                    } else {
                        document.getElementById('modalContent').innerHTML = `<div class="text-center py-8"><p class="text-red-600 font-medium">❌ Gagal memuat detail</p></div>`;
                    }
                })
                .catch(error => {
                    document.getElementById('modalContent').innerHTML = `<div class="text-center py-8"><p class="text-red-600 font-medium">⚠️ Kesalahan koneksi</p></div>`;
                });
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function updateStatus(id, status) {
            if (!confirm('Yakin ingin mengubah status?')) {
                location.reload();
                return;
            }

            fetch(`/admin/reservasi/${id}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.success ? 'Status berhasil diupdate' : 'Gagal update');
                    location.reload();
                })
                .catch(() => {
                    alert('Terjadi kesalahan');
                    location.reload();
                });
        }

        function deleteReservasi(id) {
            if (!confirm('Yakin ingin menghapus?')) return;

            fetch(`/admin/reservasi/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.success ? 'Berhasil dihapus' : 'Gagal');
                    location.reload();
                });
        }
    </script>
</body>

</html>