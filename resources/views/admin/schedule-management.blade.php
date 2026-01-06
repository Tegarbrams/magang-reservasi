<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Jadwal Reservasi - Admin</title>
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

        /* Form Styling */
        select,
        input[type="date"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            background-color: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        select:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .btn-primary {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #D4AF37 0%, #F4E5A1 100%);
            color: #000;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        /* Slot Card Styling */
        .slot-card {
            padding: 1.25rem;
            border-radius: 1rem;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .slot-available {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #86efac;
        }

        .slot-available:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.2);
            border-color: #4ade80;
        }

        .slot-booked {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-color: #fca5a5;
            cursor: not-allowed;
            opacity: 0.8;
        }

        .slot-maintenance {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #fcd34d;
        }

        .slot-maintenance:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.2);
            border-color: #f59e0b;
        }

        /* Quick Date Navigation */
        .date-nav-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .date-nav-btn:hover {
            background: #f9fafb;
            border-color: #D4AF37;
        }

        .date-nav-btn.active {
            background: linear-gradient(135deg, #D4AF37 0%, #F4E5A1 100%);
            border-color: #D4AF37;
            color: #000;
        }

        /* Info Badge */
        .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar (sama seperti sebelumnya) -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold text-yellow-500">NDALEM HANOMAN</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Dashboard</p>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.reservasi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Reservasi</span>
                </a>

                <a href="{{ route('admin.schedule-management') }}"
                    class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Kelola Jadwal</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase">Stok Management</p>
                </div>

                <a href="{{ route('admin.paket-menu') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Paket Menu</span>
                </a>

                <a href="{{ route('admin.ruangan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Ruangan</span>
                </a>

                <a href="{{ route('admin.fasilitas') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <span>Fasilitas</span>
                </a>

                <a href="{{ route('admin.menu-tambahan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Menu Tambahan</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase">User Management</p>
                </div>

                {{-- <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Data User</span>
                </a> --}}
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
            <header class="bg-white border-b border-gray-200 px-8 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Jadwal Reservasi</h2>
                        <p class="text-sm text-gray-600 mt-1">Blok/unblock jadwal untuk maintenance atau keperluan lain
                        </p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                <div class="max-w-5xl mx-auto">

                    <!-- Filter Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📍 Pilih Ruangan & Tanggal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Ruangan</label>
                                <select id="ruanganSelect" class="w-full">
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}">{{ $ruangan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                                <input type="date" id="dateSelect" class="w-full"
                                    value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Quick Navigation -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button onclick="setToday()" class="date-nav-btn">
                                📅 Hari Ini
                            </button>
                            <button onclick="setTomorrow()" class="date-nav-btn">
                                ⏭️ Besok
                            </button>
                            <button onclick="navigateDate(-1)" class="date-nav-btn">
                                ◀️ Kemarin
                            </button>
                            <button onclick="navigateDate(1)" class="date-nav-btn">
                                ▶️ Lusa
                            </button>
                        </div>

                        <button onclick="loadSchedule()" class="btn-primary w-full md:w-auto">
                            🔍 Tampilkan Slot Jadwal
                        </button>
                    </div>

                    <!-- Info Summary -->
                    <div id="infoSummary" class="hidden mb-6 fade-in">
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4">
                            <div class="flex flex-wrap items-center gap-4 justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="info-badge bg-green-100 text-green-700 border border-green-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span id="availableCount">0</span> Tersedia
                                    </div>
                                    <div class="info-badge bg-red-100 text-red-700 border border-red-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span id="bookedCount">0</span> Reservasi
                                    </div>
                                    <div class="info-badge bg-yellow-100 text-yellow-700 border border-yellow-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span id="maintenanceCount">0</span> Maintenance
                                    </div>
                                </div>
                                <div class="text-sm font-semibold text-gray-700" id="selectedDateDisplay"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Slots Container -->
                    <div id="slotsContainer" class="hidden fade-in">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">⏰ Slot Waktu Tersedia</h3>
                        <div id="slotsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Slots will be rendered here -->
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Pilih ruangan dan tanggal untuk melihat jadwal</p>
                    </div>

                </div>
            </main>
        </div>

    </div>

    <script>
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Auto load today's schedule
            // loadSchedule();
        });

        // Quick date navigation
        function setToday() {
            document.getElementById('dateSelect').value = new Date().toISOString().split('T')[0];
            loadSchedule();
        }

        function setTomorrow() {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('dateSelect').value = tomorrow.toISOString().split('T')[0];
            loadSchedule();
        }

        function navigateDate(days) {
            const currentDate = new Date(document.getElementById('dateSelect').value);
            currentDate.setDate(currentDate.getDate() + days);
            document.getElementById('dateSelect').value = currentDate.toISOString().split('T')[0];
            loadSchedule();
        }

        function loadSchedule() {
            const ruanganId = document.getElementById('ruanganSelect').value;
            const date = document.getElementById('dateSelect').value;

            if (!ruanganId || !date) {
                alert('Pilih ruangan dan tanggal terlebih dahulu');
                return;
            }

            console.log('Loading schedule...', {
                ruanganId,
                date
            });

            // Show loading
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('slotsContainer').classList.remove('hidden');
            document.getElementById('infoSummary').classList.remove('hidden');
            document.getElementById('slotsGrid').innerHTML =
                '<div class="col-span-full text-center py-8"><div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-yellow-500"></div><p class="mt-4 text-gray-600">Memuat data...</p></div>';

            // Fetch data
            fetch(`/admin/schedule/get-data?ruangan_id=${ruanganId}&month=${date.substring(0, 7)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Schedule data received:', data);

                    if (data.success) {
                        renderSlots(data.data, date);
                    } else {
                        alert('Gagal load data: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(err => {
                    console.error('Error loading schedule:', err);
                    alert('Terjadi kesalahan saat memuat data');
                });
        }

        function renderSlots(scheduleData, selectedDate) {
            const slotsGrid = document.getElementById('slotsGrid');
            slotsGrid.innerHTML = '';

            console.log('=== RENDERING SLOTS ===');
            console.log('Schedule data:', scheduleData);
            console.log('Selected date:', selectedDate);

            // Filter data untuk tanggal yang dipilih
            const dateSchedule = scheduleData.filter(s => s.date === selectedDate);
            console.log('Filtered for date:', dateSchedule);

            // Semua slot waktu (08:00 - 18:00)
            const allSlots = [];
            for (let h = 8; h <= 18; h++) {
                const timeStr = (h < 10 ? '0' + h : h) + ':00';
                allSlots.push(timeStr);
            }

            let availableCount = 0;
            let bookedCount = 0;
            let maintenanceCount = 0;

            allSlots.forEach(time => {
                const slotData = dateSchedule.find(s => s.time === time);
                const slotCard = document.createElement('div');
                slotCard.className = 'slot-card';

                console.log(`Slot ${time}:`, slotData);

                if (slotData) {
                    // 🔧 SLOT DENGAN RESERVASI (type: 'auto')
                    if (slotData.type === 'auto') {
                        bookedCount++;
                        slotCard.className += ' slot-booked';
                        slotCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-lg font-bold text-red-700">${time}</span>
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-red-700 mb-1">🔒 Sudah Direservasi</p>
                    <p class="text-xs text-red-600 mb-2">${slotData.label.substring(0, 40)}...</p>
                    <button onclick="confirmUnblockReservation('${slotData.id}', '${selectedDate}', '${time}', '${slotData.label.replace(/'/g, "\\'")}')" 
                            class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition">
                        🔓 Buka Blok Reservasi
                    </button>
                    <p class="text-xs text-red-500 mt-2 text-center">⚠️ Slot akan terbuka untuk booking lain</p>
                `;
                        slotCard.style.cursor = 'default';

                        // 🔧 SLOT MAINTENANCE (type: 'manual')
                    } else if (slotData.type === 'manual') {
                        maintenanceCount++;
                        slotCard.className += ' slot-maintenance';
                        slotCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-lg font-bold text-orange-700">${time}</span>
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-orange-700 mb-1">🔧 Maintenance</p>
                    <p class="text-xs text-orange-600 mb-3">${slotData.label.substring(0, 40)}</p>
                    <button onclick="confirmUnblockMaintenance('${slotData.id}', '${selectedDate}', '${time}')" 
                            class="w-full px-3 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg transition">
                        ❌ Hapus Blok
                    </button>
                `;
                        slotCard.style.cursor = 'default';
                    }
                } else {
                    // 🔧 SLOT TERSEDIA
                    availableCount++;
                    slotCard.className += ' slot-available';
                    slotCard.innerHTML = `
                <div class="flex items-center justify-between mb-2">
                    <span class="text-lg font-bold text-green-700">${time}</span>
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-green-700 mb-1">✅ Tersedia</p>
                <p class="text-xs text-green-600 mb-3">Slot ini dapat dibooking</p>
                <button onclick="blockSlot('${selectedDate}', '${time}')" 
                        class="w-full px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition">
                    🔒 Blok Jadwal
                </button>
            `;
                }

                slotsGrid.appendChild(slotCard);
            });

            // Update summary
            document.getElementById('availableCount').textContent = availableCount;
            document.getElementById('bookedCount').textContent = bookedCount;
            document.getElementById('maintenanceCount').textContent = maintenanceCount;

            // Format date display
            const dateObj = new Date(selectedDate);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = dateObj.toLocaleDateString('id-ID', options);
            document.getElementById('selectedDateDisplay').textContent = formattedDate;

            console.log('Summary:', {
                availableCount,
                bookedCount,
                maintenanceCount
            });
        }

        function confirmUnblockReservation(blockId, date, time, label) {
            if (!confirm(
                    `⚠️ PERINGATAN PENTING!\n\nAnda akan membuka blok reservasi:\n\nTanggal: ${date}\nJam: ${time}\nReservasi: ${label}\n\n❗ PERHATIAN:\n✓ Slot ini akan tersedia untuk booking customer lain\n✓ Reservasi yang ada harus dibatalkan secara manual di menu Reservasi\n✓ Customer yang sudah booking perlu dikonfirmasi ulang\n\n⚠️ Lanjutkan membuka blok ini?`
                    )) {
                return;
            }

            const ruanganId = document.getElementById('ruanganSelect').value;

            console.log('Unblocking reservation...', {
                blockId,
                ruanganId,
                date,
                time
            });

            fetch('/admin/schedule/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ruangan_id: ruanganId,
                        tanggal: date,
                        jam: time,
                        action: 'unblock'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Unblock response:', data);

                    if (data.success) {
                        alert(
                            '✅ Blok reservasi berhasil dibuka!\n\n⚠️ JANGAN LUPA:\n- Batalkan reservasi terkait di menu Reservasi\n- Informasikan customer tentang pembatalan');
                        loadSchedule();
                    } else {
                        alert('❌ ' + (data.message || 'Gagal membuka blok reservasi'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('❌ Terjadi kesalahan saat membuka blok');
                });
        }

        // 🔧 FIXED: Unblock Maintenance
        function confirmUnblockMaintenance(blockId, date, time) {
            if (!confirm(
                    `Hapus blok maintenance?\n\nTanggal: ${date}\nJam: ${time}\n\nSlot ini akan tersedia kembali untuk reservasi.`
                    )) {
                return;
            }

            const ruanganId = document.getElementById('ruanganSelect').value;

            console.log('Unblocking maintenance...', {
                blockId,
                ruanganId,
                date,
                time
            });

            fetch('/admin/schedule/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ruangan_id: ruanganId,
                        tanggal: date,
                        jam: time,
                        action: 'unblock'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Unblock response:', data);

                    if (data.success) {
                        alert('✅ Blok maintenance berhasil dihapus');
                        loadSchedule();
                    } else {
                        alert('❌ ' + (data.message || 'Gagal menghapus blok'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('❌ Terjadi kesalahan');
                });
        }

        // 🔧 Block manual
        function blockSlot(date, time) {
            const ruanganId = document.getElementById('ruanganSelect').value;
            const keterangan = prompt(
                `Blok jadwal untuk maintenance?\n\nTanggal: ${date}\nJam: ${time}\n\nMasukkan keterangan:`,
                'Maintenance rutin'
            );

            if (keterangan === null) return;

            console.log('Blocking slot...', {
                ruanganId,
                date,
                time,
                keterangan
            });

            fetch('/admin/schedule/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ruangan_id: ruanganId,
                        tanggal: date,
                        jam: time,
                        action: 'block',
                        keterangan: keterangan
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Block response:', data);

                    if (data.success) {
                        alert('✅ Jadwal berhasil diblok untuk maintenance');
                        loadSchedule();
                    } else {
                        alert('❌ ' + (data.message || 'Gagal memblok jadwal'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('❌ Terjadi kesalahan');
                });
        }

        function blockSlot(date, time) {
            const ruanganId = document.getElementById('ruanganSelect').value;
            const keterangan = prompt(
                `Blok jadwal untuk maintenance?\n\nTanggal: ${date}\nJam: ${time}\n\nMasukkan keterangan:`,
                'Maintenance rutin'
            );

            if (keterangan === null) return; // User cancelled

            console.log('Blocking slot...', {
                ruanganId,
                date,
                time,
                keterangan
            });

            fetch('/admin/schedule/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ruangan_id: ruanganId,
                        tanggal: date,
                        jam: time,
                        action: 'block',
                        keterangan: keterangan
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Block response:', data);

                    if (data.success) {
                        alert('✅ Jadwal berhasil diblok untuk maintenance');
                        loadSchedule(); // Reload
                    } else {
                        alert('❌ ' + (data.message || 'Gagal memblok jadwal'));
                    }
                })
                .catch(err => {
                    console.error('Error blocking slot:', err);
                    alert('Terjadi kesalahan saat memblok jadwal');
                });
        }

        function unblockSlot(date, time) {
            if (!confirm(
                    `Hapus blok maintenance?\n\nTanggal: ${date}\nJam: ${time}\n\nSlot ini akan tersedia kembali untuk reservasi.`
                )) {
                return;
            }

            const ruanganId = document.getElementById('ruanganSelect').value;

            console.log('Unblocking maintenance slot...', {
                ruanganId,
                date,
                time
            });

            fetch('/admin/schedule/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ruangan_id: ruanganId,
                        tanggal: date,
                        jam: time,
                        action: 'unblock'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Unblock response:', data);

                    if (data.success) {
                        alert('✅ Blok maintenance berhasil dihapus');
                        loadSchedule(); // Reload
                    } else {
                        alert('❌ ' + (data.message || 'Gagal menghapus blok'));
                    }
                })
                .catch(err => {
                    console.error('Error unblocking slot:', err);
                    alert('Terjadi kesalahan saat menghapus blok');
                });
        }

        function unblockReservation(date, time, label) {
            if (!confirm(
                    `⚠️ PERINGATAN: Buka blok reservasi?\n\nTanggal: ${date}\nJam: ${time}\nReservasi: ${label}\n\n❗ Tindakan ini akan:\n✓ Membuka slot untuk booking customer lain\n✓ Reservasi yang ada mungkin perlu dibatalkan manual\n\nLanjutkan?`
                )) {
                return;
            }

            const ruanganId = document.getElementById('ruanganSelect').value;

            console.log('Unblocking reservation slot...', {
                ruanganId,
                date,
                time
            });

            fetch('/admin/schedule/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ruangan_id: ruanganId,
                        tanggal: date,
                        jam: time,
                        action: 'unblock'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Unblock reservation response:', data);

                    if (data.success) {
                        alert(
                            '✅ Blok reservasi berhasil dibuka\n\n⚠️ Pastikan untuk membatalkan reservasi terkait di menu Reservasi!'
                            );
                        loadSchedule(); // Reload
                    } else {
                        alert('❌ ' + (data.message || 'Gagal membuka blok reservasi'));
                    }
                })
                .catch(err => {
                    console.error('Error unblocking reservation:', err);
                    alert('Terjadi kesalahan saat membuka blok reservasi');
                });
        }
    </script>
</body>

</html>
