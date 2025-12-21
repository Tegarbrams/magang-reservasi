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
        input[type="month"] {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background-color: white;
            font-size: 0.875rem;
        }

        select:focus,
        input[type="month"]:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        button {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #D4AF37 0%, #F4E5A1 100%);
            color: #000;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #f3f4f6;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        tbody td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            font-size: 0.875rem;
        }

        tbody td:first-child {
            text-align: left;
            font-weight: 500;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Slot Status Colors */
        .slot-available {
            background-color: #f0fdf4;
            color: #16a34a;
            cursor: pointer;
            transition: all 0.2s;
        }

        .slot-available:hover {
            background-color: #dcfce7;
            transform: scale(1.05);
        }

        .slot-booked {
            background-color: #fee2e2;
            color: #dc2626;
            cursor: not-allowed;
        }

        .slot-maintenance {
            background-color: #fef3c7;
            color: #d97706;
            cursor: pointer;
        }

        .slot-maintenance:hover {
            background-color: #fde68a;
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

                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Data User</span>
                </a>
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
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Jadwal Reservasi</h2>
                        <p class="text-sm text-gray-600">Blok/unblock jadwal untuk maintenance atau keperluan lain</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                <div class="max-w-7xl mx-auto">

                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Kelola Jadwal Ruangan</h1>
                    </div>

                    <!-- Filter -->
                    <div class="bg-white p-6 rounded-xl shadow-md mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Ruangan</label>
                                <select id="ruanganSelect" class="form-select w-full">
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}">{{ $ruangan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                                <input type="month" id="monthSelect" class="form-control w-full"
                                    value="{{ now()->format('Y-m') }}">
                            </div>
                            <div class="flex items-end">
                                <button onclick="loadSchedule()" class="btn btn-primary w-full">Tampilkan
                                    Jadwal</button>
                            </div>
                        </div>
                    </div>

                    <!-- Kalender Table -->
                    <div id="calendarContainer" class="bg-white rounded-xl shadow-md overflow-hidden">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 text-left">Tanggal</th>
                                    @for ($i = 8; $i <= 18; $i++)
                                        <th class="p-3 text-center">{{ sprintf('%02d:00', $i) }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody id="calendarBody">
                                <!-- Diisi oleh JS -->
                            </tbody>
                        </table>
                    </div>

            </main>
        </div>

    </div>

    <!-- Modal for Block/Unblock -->
    <div id="actionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-md w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Block Jadwal</h3>
            </div>
            <div class="p-6">
                <div id="modalContent">
                    <!-- Dynamic content -->
                </div>
            </div>
        </div>
    </div>

    <script>
    // Load schedule saat halaman dimuat
  // Load schedule saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadSchedule();
});

function loadSchedule() {
    const ruanganId = document.getElementById('ruanganSelect').value;
    const month = document.getElementById('monthSelect').value;

    if (!ruanganId || !month) {
        alert('Pilih ruangan dan bulan terlebih dahulu');
        return;
    }

    console.log('Loading schedule...', { ruanganId, month });

    // Show loading
    document.getElementById('calendarBody').innerHTML = 
        '<tr><td colspan="12" class="text-center py-8 text-gray-500"><div class="spinner-border text-warning"></div><br>Loading...</td></tr>';

    // PERBAIKAN: gunakan GET method dan query params yang benar
    fetch(`/admin/schedule/get-data?ruangan_id=${ruanganId}&month=${month}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => {
        console.log('Response status:', res.status);
        return res.json();
    })
    .then(data => {
        console.log('Schedule data received:', data);
        
        if (data.success) {
            renderCalendar(data.data, month);
        } else {
            alert('Gagal load data: ' + (data.message || 'Unknown error'));
            document.getElementById('calendarBody').innerHTML = 
                '<tr><td colspan="12" class="text-center py-8 text-red-500">Gagal memuat data</td></tr>';
        }
    })
    .catch(err => {
        console.error('Error loading schedule:', err);
        alert('Terjadi kesalahan saat memuat data');
        document.getElementById('calendarBody').innerHTML = 
            '<tr><td colspan="12" class="text-center py-8 text-red-500">Terjadi kesalahan</td></tr>';
    });
}

function renderCalendar(scheduleData, month) {
    const calendarBody = document.getElementById('calendarBody');
    calendarBody.innerHTML = '';

    const startDate = new Date(`${month}-01`);
    const endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);
    const today = new Date().toISOString().split('T')[0];

    console.log('Rendering calendar from', startDate, 'to', endDate);
    console.log('Schedule data:', scheduleData);

    for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
        const dateStr = d.toISOString().split('T')[0];
        const row = document.createElement('tr');
        
        // Date cell dengan highlight hari ini
        const dateCell = document.createElement('td');
        dateCell.className = 'p-3 border-t font-medium';
        
        const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const dayName = dayNames[d.getDay()];
        
        if (dateStr === today) {
            dateCell.innerHTML = `<span class="text-blue-600 font-bold">${dateStr}<br><small class="text-xs">(${dayName} - Hari ini)</small></span>`;
        } else {
            dateCell.innerHTML = `${dateStr}<br><small class="text-xs text-gray-500">${dayName}</small>`;
        }
        row.appendChild(dateCell);

        // Loop jam 08:00 - 18:00
        for (let h = 8; h <= 18; h++) {
            const time = `${h.toString().padStart(2, '0')}:00`;
            const slotData = scheduleData.find(s => s.date === dateStr && s.time === time);

            const td = document.createElement('td');
            td.className = 'p-3 border-t text-center';

            if (slotData) {
                // Ada data (booked atau maintenance)
                if (slotData.type === 'booked') {
                    // Booked by reservation (auto) - TIDAK BISA DI-UNBLOCK
                    td.className += ' slot-booked';
                    td.innerHTML = `
                        <div class="text-xs font-medium">Reservasi</div>
                        <div class="text-xs">${slotData.label.substring(0, 20)}</div>
                        <div class="text-xs text-gray-600 mt-1">
                            <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Terkunci
                        </div>
                    `;
                    td.title = slotData.label + '\n\nTerkunci oleh reservasi aktif.\nBatalkan reservasi di menu Reservasi untuk membuka slot ini.';
                    td.style.cursor = 'not-allowed';
                    
                } else if (slotData.type === 'maintenance') {
                    // Manual maintenance block - BISA DI-UNBLOCK
                    td.className += ' slot-maintenance';
                    td.innerHTML = `
                        <div class="text-xs font-medium">Maintenance</div>
                        <div class="text-xs">${slotData.label.substring(0, 15)}</div>
                        <div class="text-xs text-orange-700 mt-1">
                            <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Klik untuk unblock
                        </div>
                    `;
                    td.onclick = () => unblockSlot(dateStr, time);
                    td.style.cursor = 'pointer';
                    td.title = 'Klik untuk menghapus blok maintenance';
                }
            } else {
                // Available slot - BISA DI-BLOCK
                td.className += ' slot-available';
                td.innerHTML = `
                    <div class="text-xs font-medium text-green-600">✓ Tersedia</div>
                    <div class="text-xs text-gray-500 mt-1">Klik untuk block</div>
                `;
                td.onclick = () => blockSlot(dateStr, time);
                td.style.cursor = 'pointer';
                td.title = 'Klik untuk blok jadwal ini (maintenance)';
            }

            row.appendChild(td);
        }

        calendarBody.appendChild(row);
    }

    console.log('Calendar rendered successfully');
}

function blockSlot(date, time) {
    const ruanganId = document.getElementById('ruanganSelect').value;
    const keterangan = prompt(
        `Block jadwal untuk maintenance?\n\nTanggal: ${date}\nJam: ${time}\n\nMasukkan keterangan (opsional):`, 
        'Maintenance'
    );
    
    if (keterangan === null) return; // User cancel

    console.log('Blocking slot...', { ruanganId, date, time, keterangan });

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
            alert('✓ Jadwal berhasil diblok untuk maintenance');
            loadSchedule(); // Reload calendar
        } else {
            alert('✗ ' + (data.message || 'Gagal memblok jadwal'));
        }
    })
    .catch(err => {
        console.error('Error blocking slot:', err);
        alert('Terjadi kesalahan saat memblok jadwal');
    });
}

function unblockSlot(date, time) {
    if (!confirm(`Hapus blok maintenance?\n\nTanggal: ${date}\nJam: ${time}\n\nSlot ini akan tersedia kembali untuk reservasi.`)) {
        return;
    }

    const ruanganId = document.getElementById('ruanganSelect').value;

    console.log('Unblocking slot...', { ruanganId, date, time });

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
            alert('✓ Blok maintenance berhasil dihapus');
            loadSchedule(); // Reload calendar
        } else {
            alert('✗ ' + (data.message || 'Gagal menghapus blok'));
        }
    })
    .catch(err => {
        console.error('Error unblocking slot:', err);
        alert('Terjadi kesalahan saat menghapus blok');
    });
}
</script>
</body>

</html>
