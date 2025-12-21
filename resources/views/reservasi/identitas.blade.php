@include('template.header')
<link rel="stylesheet" href="{{ asset('css/reservasi.css') }}">

<style>
    .paket-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .paket-card:hover:not(.disabled) {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .paket-card.selected {
        border-color: #FFB22C;
        background-color: #FFF8E7;
    }

    .paket-card.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .paket-img {
        height: 200px;
        object-fit: cover;
    }

    .progress-step {
        width: 100%;
        height: 8px;
        background-color: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-step.active {
        background-color: #FFB22C;
    }

    .slide-content {
        display: none;
    }

    .slide-content.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }

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

    .facility-checkbox:checked+label {
        background-color: #FFF8E7;
        border-color: #FFB22C;
    }

    .selected-room-card {
        background: linear-gradient(135deg, #FFB22C 0%, #FFA500 100%);
        color: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(255, 178, 44, 0.3);
        margin-bottom: 20px;
    }

    .room-locked-badge {
        background-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 15px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 600;
    }

    /* Time Slot Styling */
    .time-slot {
        padding: 12px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: white;
    }

    .time-slot:hover:not(.blocked) {
        border-color: #FFB22C;
        background-color: #FFF8E7;
        transform: scale(1.05);
    }

    .time-slot.selected {
        border-color: #FFB22C;
        background-color: #FFB22C;
        color: white;
    }

    .time-slot.blocked {
        background-color: #fee2e2;
        border-color: #ef4444;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .time-slot.blocked:hover {
        transform: none;
    }

    /* DP Card Styling */
    .dp-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: white;
    }

    .dp-card:hover {
        border-color: #FFB22C;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 178, 44, 0.3);
    }

    .dp-card.selected {
        border-color: #FFB22C;
        background-color: #FFF8E7;
    }

    .dp-card .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .dp-card .badge.recommended {
        background-color: #10b981;
        color: white;
    }
</style>

<section class="py-5" style="background-color: #FFB22C; min-height: 100vh;">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold text-dark">Reservasi Tempat</h2>

        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-dark">Langkah <span id="currentStep">1</span> dari 3</span>
            </div>
            <div class="d-flex gap-2">
                <div class="progress-step active" id="step1Progress"></div>
                <div class="progress-step" id="step2Progress"></div>
                <div class="progress-step" id="step3Progress"></div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div id="errorMessage" class="alert alert-danger d-none">
            <p class="fw-bold mb-1">✗ Error!</p>
            <p class="mb-0" id="errorText"></p>
        </div>

        <!-- Form Container -->
        <form id="reservasiForm" class="bg-white p-4 rounded shadow">
            @csrf

            <!-- SLIDE 1: IDENTITAS -->
            <div class="slide-content active" id="slide1">
                <h3 class="fw-bold mb-3">Informasi Identitas</h3>
                <p class="text-muted mb-4">Silakan isi data diri Anda dengan lengkap</p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                        <div class="text-danger small mt-1 d-none" id="error-nama"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_hp" class="form-label">Nomor Handphone *</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" required>
                        <div class="text-danger small mt-1 d-none" id="error-no_hp"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <div class="text-danger small mt-1 d-none" id="error-email"></div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 2: LAYANAN -->
            <div class="slide-content" id="slide2">
                <h3 class="fw-bold mb-3">Pilih Paket & Layanan</h3>

                <!-- Selected Room Display -->
                <div id="selectedRoomDisplay" class="d-none">
                    <div class="selected-room-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="room-locked-badge">
                                    🔒 Ruangan Terpilih
                                </span>
                            </div>
                            <a href="/reservasi" class="btn btn-light btn-sm">Ganti Ruangan</a>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="fw-bold mb-2" id="selectedRoomName">-</h4>
                                <p class="mb-1">📍 Kapasitas: <span id="selectedRoomCapacity">-</span> orang</p>
                                <p class="mb-0">💰 Harga: Rp <span id="selectedRoomPrice">-</span></p>
                            </div>
                            <div class="col-md-4 text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                    fill="rgba(255,255,255,0.3)" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Jenis Ruangan -->
                    <div class="col-md-12 mb-3" id="ruanganSelector">
                        <label for="ruangan" class="form-label">Jenis Ruangan *</label>
                        <select name="ruangan" id="ruangan" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                        </select>
                        <div class="text-danger small mt-1 d-none" id="error-ruangan"></div>
                    </div>

                    <!-- Pilih Paket -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold">Pilih Paket Menu *</label>
                        <input type="hidden" name="paket_menu" id="paket_menu" required>
                        <div class="text-danger small mt-1 d-none" id="error-paket_menu"></div>
                        <div class="row g-3" id="paketContainer"></div>
                    </div>

                    <!-- Tanggal -->
                    <div class="col-md-12 mb-3">
                        <label for="tanggal" class="form-label">Tanggal Reservasi *</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        <div class="text-danger small mt-1 d-none" id="error-tanggal"></div>
                    </div>

                    <!-- Time Slot Selection -->
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Pilih Jam Check-in *</label>
                        <input type="hidden" name="jam" id="jam" required>
                        <div class="text-danger small mt-1 d-none" id="error-jam"></div>
                        <div id="timeSlotsContainer" class="row g-2">
                            <div class="col-12 text-center text-muted py-4">
                                Pilih tanggal dan ruangan terlebih dahulu
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Orang -->
                    <div class="col-md-12 mb-3">
                        <label for="jumlah_orang" class="form-label">Jumlah Orang *</label>
                        <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control" min="1"
                            required>
                        <small class="text-muted" id="capacityWarning"></small>
                        <div class="text-danger small mt-1 d-none" id="error-jumlah_orang"></div>
                    </div>

                    <!-- Fasilitas Tambahan -->
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Fasilitas Tambahan (Opsional)</label>
                        <div id="fasilitasContainer" class="row g-2"></div>
                    </div>

                    <!-- Menu Tambahan -->
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Menu Tambahan (Opsional)</label>
                        <div id="menuTambahanContainer" class="row g-2"></div>
                    </div>

                    <!-- Catatan -->
                    <div class="col-12 mb-3">
                        <label for="pesan" class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea name="pesan" id="pesan" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Total Harga -->
                    <div class="col-12 mb-3">
                        <div class="alert alert-warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Harga:</span>
                                <span id="totalHarga" class="fs-4 fw-bold text-success">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3: PEMBAYARAN -->
            <div class="slide-content" id="slide3">
                <h3 class="fw-bold mb-3">Pembayaran</h3>
                <p class="text-muted mb-4">Pilih metode DP dan unggah bukti pembayaran</p>

                <!-- Pilihan DP -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Pilih DP *</label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="dp-card" data-percentage="20">
                                <div class="badge">20%</div>
                                <h4 class="fw-bold">DP Minimal</h4>
                                <p class="mb-0" id="dp20Amount">Rp 0</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dp-card" data-percentage="50">
                                <div class="badge recommended">Rekomendasi</div>
                                <h4 class="fw-bold">50%</h4>
                                <p class="mb-0" id="dp50Amount">Rp 0</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dp-card" data-percentage="100">
                                <div class="badge">Lunas</div>
                                <h4 class="fw-bold">100%</h4>
                                <p class="mb-0" id="fullAmount">Rp 0</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="dp_percentage" id="dp_percentage" required>
                    <input type="hidden" name="tipe_pembayaran" id="tipe_pembayaran">
                    <div class="text-danger small mt-1 d-none" id="error-dp_percentage"></div>
                </div>

                <!-- Total dan DP Preview -->
                <div class="alert alert-info mb-4 d-none" id="selectedPaymentInfo">
                    <h5 class="fw-bold">Detail Pembayaran:</h5>
                    <p class="mb-1">Metode: <span id="infoMetode">-</span></p>
                    <p class="mb-1">Jumlah Bayar: <span id="infoJumlah" class="fw-bold text-success">Rp 0</span></p>
                    <p class="mb-0">Sisa Bayar: <span id="infoSisa">Rp 0</span></p>
                </div>

                <!-- Upload Bukti -->
                <div class="mb-3">
                    <label for="bukti" class="form-label fw-bold">Upload Bukti Pembayaran *</label>
                    <input type="file" name="bukti" id="bukti" class="form-control" accept="image/*" required>
                    <div class="text-danger small mt-1 d-none" id="error-bukti"></div>
                    <div id="imagePreview" class="mt-3 d-none">
                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="button" id="prevBtn" class="btn btn-secondary d-none">
                    ← Kembali
                </button>

                <button type="button" id="nextBtn" class="btn btn-warning">
                    Lanjut →
                </button>

                <button type="submit" id="submitBtn" class="btn btn-success d-none">
                    ✓ Kirim Reservasi
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    let currentSlide = 1;
    const totalSlides = 3;
    const API_BASE_URL = '{{ url('/api') }}';

    const urlParams = new URLSearchParams(window.location.search);
    const preselectedRoomId = urlParams.get('ruangan');

    const database = {
        paket_menu: @json($paketMenu ?? collect()),
        ruangan: @json($ruangan ?? collect()),
        fasilitas: @json($fasilitas ?? collect()),
        menu_tambahan: @json($menuTambahan ?? collect()),
    };

    let totalPrice = 0;
    let selectedTime = null;

    // ============================================
    // ROOM PRESELECTION
    // ============================================
    function handlePreselectedRoom() {
        if (preselectedRoomId) {
            const selectedRoom = database.ruangan.find(r => r.id == preselectedRoomId);
            if (selectedRoom) {
                document.getElementById('ruangan').value = preselectedRoomId;
                document.getElementById('selectedRoomDisplay').classList.remove('d-none');
                document.getElementById('selectedRoomName').textContent = selectedRoom.nama;
                document.getElementById('selectedRoomCapacity').textContent = selectedRoom.kapasitas;
                document.getElementById('selectedRoomPrice').textContent = Number(selectedRoom.harga).toLocaleString(
                    'id-ID');
                document.getElementById('ruanganSelector').classList.add('d-none');
                updateCapacityWarning(selectedRoom.kapasitas);
                calculateTotal();
            }
        }
    }

    function updateCapacityWarning(capacity) {
        const warningEl = document.getElementById('capacityWarning');
        warningEl.textContent = `Kapasitas maksimum ruangan: ${capacity} orang`;
        const jumlahOrangInput = document.getElementById('jumlah_orang');
        jumlahOrangInput.setAttribute('max', capacity);
        jumlahOrangInput.addEventListener('input', function() {
            if (parseInt(this.value) > capacity) {
                warningEl.classList.add('text-danger');
                warningEl.textContent = `⚠️ Jumlah melebihi kapasitas! Maksimum ${capacity} orang`;
            } else {
                warningEl.classList.remove('text-danger');
                warningEl.textContent = `Kapasitas maksimum ruangan: ${capacity} orang`;
            }
        });
    }

    // ============================================
    // RENDER FUNCTIONS
    // ============================================
    function renderPaketMenu() {
        const container = document.getElementById('paketContainer');
        if (database.paket_menu.length === 0) {
            container.innerHTML = '<p class="text-muted">Tidak ada paket tersedia</p>';
            return;
        }
        container.innerHTML = database.paket_menu.map(menu => `
            <div class="col-md-4">
                <div class="card paket-card h-100 ${menu.stock === 0 ? 'disabled' : ''}" 
                     onclick="${menu.stock > 0 ? `selectPaket(${menu.id})` : ''}" 
                     id="paket-${menu.id}">
                    <img src="${menu.gambar || '{{ asset('img/paket1.jpg') }}'}" class="card-img-top paket-img" alt="${menu.nama}">
                    <div class="card-body text-center">
                        <h5 class="card-title">${menu.nama}</h5>
                        <p class="card-text fw-bold">Rp ${Number(menu.harga).toLocaleString('id-ID')}</p>
                        <p class="small ${menu.stock === 0 ? 'text-danger' : 'text-success'}">
                            ${menu.stock === 0 ? '✗ Tidak Tersedia' : `✓ ${menu.stock} tersedia`}
                        </p>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function renderRuangan() {
        const select = document.getElementById('ruangan');
        select.innerHTML = '<option value="">-- Pilih Ruangan --</option>' + database.ruangan.map(ruang => `
            <option value="${ruang.id}" ${preselectedRoomId == ruang.id ? 'selected' : ''}>
                ${ruang.nama} - Kapasitas: ${ruang.kapasitas} (Rp ${Number(ruang.harga).toLocaleString('id-ID')})
            </option>
        `).join('');
        select.addEventListener('change', function() {
            const selectedRoom = database.ruangan.find(r => r.id == this.value);
            if (selectedRoom) {
                updateCapacityWarning(selectedRoom.kapasitas);
            }
            loadAvailableTimeSlots();
            calculateTotal();
        });
    }

    function renderFasilitas() {
        const container = document.getElementById('fasilitasContainer');
        if (database.fasilitas.length === 0) {
            container.innerHTML = '<p class="text-muted small">Tidak ada fasilitas tersedia</p>';
            return;
        }
        container.innerHTML = database.fasilitas.map(fas => `
            <div class="col-md-6">
                <div class="form-check p-3 border rounded">
                    <input class="form-check-input facility-checkbox" type="checkbox" name="fasilitas[]" value="${fas.id}" id="fas-${fas.id}" onchange="calculateTotal()">
                    <label class="form-check-label w-100" for="fas-${fas.id}">
                        <div class="fw-semibold">${fas.nama}</div>
                        <div class="small text-muted">Rp ${Number(fas.harga).toLocaleString('id-ID')}</div>
                    </label>
                </div>
            </div>
        `).join('');
    }

    function renderMenuTambahan() {
        const container = document.getElementById('menuTambahanContainer');
        if (database.menu_tambahan.length === 0) {
            container.innerHTML = '<p class="text-muted small">Tidak ada menu tambahan tersedia</p>';
            return;
        }
        container.innerHTML = database.menu_tambahan.map(menu => `
            <div class="col-md-6">
                <div class="form-check p-3 border rounded">
                    <input class="form-check-input facility-checkbox" type="checkbox" name="menu_tambahan[]" value="${menu.id}" id="menu-${menu.id}" onchange="calculateTotal()">
                    <label class="form-check-label w-100" for="menu-${menu.id}">
                        <div class="fw-semibold">${menu.nama}</div>
                        <div class="small text-muted">Rp ${Number(menu.harga).toLocaleString('id-ID')}</div>
                    </label>
                </div>
            </div>
        `).join('');
    }

    function selectPaket(id) {
        document.getElementById('paket_menu').value = id;
        document.querySelectorAll('.paket-card').forEach(card => card.classList.remove('selected'));
        document.getElementById('paket-' + id).classList.add('selected');
        calculateTotal();
    }

    // ============================================
    // TIME SLOT FUNCTIONS
    // ============================================
    function loadAvailableTimeSlots() {
        const ruanganId = document.getElementById('ruangan').value;
        const tanggal = document.getElementById('tanggal').value;
        const container = document.getElementById('timeSlotsContainer');

        console.log('Loading time slots...', { ruanganId, tanggal }); // Debug

        if (!ruanganId || !tanggal) {
            container.innerHTML =
                '<div class="col-12 text-center text-muted py-4">Pilih tanggal dan ruangan terlebih dahulu</div>';
            return;
        }

        // Show loading
        container.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-warning"></div></div>';

        fetch(`/api/check-available-slots?ruangan_id=${ruanganId}&tanggal=${tanggal}`)
            .then(res => {
                console.log('Response status:', res.status); // Debug
                return res.json();
            })
            .then(data => {
                console.log('API Response:', data); // Debug
                if (data.status) {
                    renderTimeSlots(data.data.available_slots, data.data.unavailable_slots);
                } else {
                    container.innerHTML = `<div class="col-12 text-center text-danger py-4">${data.message || 'Gagal memuat jam'}</div>`;
                }
            })
            .catch(err => {
                console.error('Error loading time slots:', err);
                container.innerHTML = '<div class="col-12 text-center text-danger py-4">Gagal memuat data jam. Coba lagi.</div>';
            });
    }

    function renderTimeSlots(available, unavailable) {
        const container = document.getElementById('timeSlotsContainer');
        container.innerHTML = '';

        console.log('Rendering time slots...', { available, unavailable }); // Debug

        // Jika tidak ada data sama sekali, tampilkan jam default 08:00 - 18:00
        if ((!available || available.length === 0) && (!unavailable || unavailable.length === 0)) {
            // Generate default time slots
            const defaultSlots = [];
            for (let hour = 8; hour <= 18; hour++) {
                defaultSlots.push(`${String(hour).padStart(2, '0')}:00`);
            }
            available = defaultSlots;
            unavailable = [];
        }

        const allSlots = [...new Set([...available, ...unavailable])].sort();

        if (allSlots.length === 0) {
            container.innerHTML = '<div class="col-12 text-center text-muted py-4">Tidak ada slot waktu tersedia</div>';
            return;
        }

        allSlots.forEach(time => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3';
            
            const div = document.createElement('div');
            div.className = 'time-slot';
            div.innerHTML = `
                <div class="fw-bold">${time}</div>
                <div class="small">${unavailable.includes(time) ? '✖ Penuh' : '✓ Tersedia'}</div>
            `;

            if (unavailable.includes(time)) {
                div.classList.add('blocked');
            } else {
                div.onclick = () => selectTimeSlot(div, time);
            }

            col.appendChild(div);
            container.appendChild(col);
        });
    }

    function selectTimeSlot(element, time) {
        document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('jam').value = time;
    }

    // ============================================
    // CALCULATE TOTAL
    // ============================================
    function calculateTotal() {
        let total = 0;

        const paketId = document.getElementById('paket_menu').value;
        const jumlahOrang = parseInt(document.getElementById('jumlah_orang').value) || 0;

        if (paketId && jumlahOrang > 0) {
            const paket = database.paket_menu.find(p => p.id == paketId);
            if (paket) total += Number(paket.harga) * jumlahOrang;
        }

        const ruanganId = document.getElementById('ruangan').value;
        if (ruanganId) {
            const ruang = database.ruangan.find(r => r.id == ruanganId);
            if (ruang) total += Number(ruang.harga);
        }

        document.querySelectorAll('input[name="fasilitas[]"]:checked').forEach(cb => {
            const fas = database.fasilitas.find(f => f.id == cb.value);
            if (fas) total += Number(fas.harga);
        });

        document.querySelectorAll('input[name="menu_tambahan[]"]:checked').forEach(cb => {
            const menu = database.menu_tambahan.find(m => m.id == cb.value);
            if (menu) total += Number(menu.harga);
        });

        totalPrice = total;
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        updateDPAmounts();
        updateDpAmount();
        
        return total;
    }

    // ============================================
    // DP SELECTION
    // ============================================
    function updateDPAmounts() {
        const dp20 = Math.round(totalPrice * 0.2);
        const dp50 = Math.round(totalPrice * 0.5);

        document.getElementById('dp20Amount').textContent = 'Rp ' + dp20.toLocaleString('id-ID');
        document.getElementById('dp50Amount').textContent = 'Rp ' + dp50.toLocaleString('id-ID');
        document.getElementById('fullAmount').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }

    function updateDpAmount() {
        const total = totalPrice;
        const percentage = document.getElementById('dp_percentage').value;
        
        if (!percentage) return;
        
        const dpAmount = Math.round(total * percentage / 100);
        const sisaBayar = total - dpAmount;
        
        let metode = percentage === '20' ? 'DP 20%' : (percentage === '50' ? 'DP 50%' : 'Full Payment (100%)');
        
        document.getElementById('infoMetode').textContent = metode;
        document.getElementById('infoJumlah').textContent = 'Rp ' + dpAmount.toLocaleString('id-ID');
        document.getElementById('infoSisa').textContent = 'Rp ' + sisaBayar.toLocaleString('id-ID');
        document.getElementById('selectedPaymentInfo').classList.remove('d-none');
    }

    // ============================================
    // VALIDATION
    // ============================================
    function clearErrors() {
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.textContent = '';
            el.classList.add('d-none');
        });
        document.getElementById('errorMessage').classList.add('d-none');
    }

    function showError(fieldName, message) {
        const errorEl = document.getElementById('error-' + fieldName);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.remove('d-none');
        }
    }

    function showGeneralError(message) {
        document.getElementById('errorText').textContent = message;
        document.getElementById('errorMessage').classList.remove('d-none');
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function validateSlide(slide) {
        clearErrors();
        let isValid = true;

        if (slide === 1) {
            const nama = document.getElementById('nama').value.trim();
            const no_hp = document.getElementById('no_hp').value.trim();
            const email = document.getElementById('email').value.trim();

            if (!nama) {
                showError('nama', 'Nama lengkap harus diisi');
                isValid = false;
            }
            if (!no_hp) {
                showError('no_hp', 'Nomor handphone harus diisi');
                isValid = false;
            }
            if (!email) {
                showError('email', 'Email harus diisi');
                isValid = false;
            }
        }

        if (slide === 2) {
            const paket = document.getElementById('paket_menu').value;
            const ruangan = document.getElementById('ruangan').value;
            const jam = document.getElementById('jam').value;
            const tanggal = document.getElementById('tanggal').value;
            const jumlah = document.getElementById('jumlah_orang').value;

            if (!paket) {
                showError('paket_menu', 'Paket menu harus dipilih');
                isValid = false;
            }
            if (!ruangan) {
                showError('ruangan', 'Ruangan harus dipilih');
                isValid = false;
            }
            if (!jam) {
                showError('jam', 'Jam harus dipilih');
                isValid = false;
            }
            if (!tanggal) {
                showError('tanggal', 'Tanggal harus dipilih');
                isValid = false;
            }
            if (!jumlah || jumlah < 1) {
                showError('jumlah_orang', 'Jumlah orang minimal 1');
                isValid = false;
            }

            const selectedRoom = database.ruangan.find(r => r.id == ruangan);
            if (selectedRoom && parseInt(jumlah) > selectedRoom.kapasitas) {
                showError('jumlah_orang', `Jumlah orang melebihi kapasitas ruangan (max ${selectedRoom.kapasitas})`);
                isValid = false;
            }
        }

        if (slide === 3) {
            const bukti = document.getElementById('bukti') ? document.getElementById('bukti').files.length : 0;
            const dpPercentage = document.getElementById('dp_percentage').value;

            if (!dpPercentage) {
                showError('dp_percentage', 'Pilih metode DP');
                isValid = false;
            }
            if (bukti === 0) {
                showError('bukti', 'Bukti pembayaran harus diunggah');
                isValid = false;
            }
        }

        return isValid;
    }

    // ============================================
    // NAVIGATION
    // ============================================
    function nextSlide() {
        if (!validateSlide(currentSlide)) return;

        if (currentSlide < totalSlides) {
            currentSlide++;
            showSlide(currentSlide);
            updateProgress();
        }
    }

    function previousSlide() {
        if (currentSlide > 1) {
            currentSlide--;
            showSlide(currentSlide);
            updateProgress();
        }
    }

    function showSlide(slide) {
        document.querySelectorAll('.slide-content').forEach(el => el.classList.remove('active'));
        document.getElementById('slide' + slide).classList.add('active');

        document.getElementById('prevBtn').classList.toggle('d-none', slide === 1);
        document.getElementById('nextBtn').classList.toggle('d-none', slide === totalSlides);
        document.getElementById('submitBtn').classList.toggle('d-none', slide !== totalSlides);
    }

    function updateProgress() {
        document.getElementById('currentStep').textContent = currentSlide;
        document.getElementById('step1Progress').classList.toggle('active', currentSlide >= 1);
        document.getElementById('step2Progress').classList.toggle('active', currentSlide >= 2);
        document.getElementById('step3Progress').classList.toggle('active', currentSlide >= 3);
    }

    // ============================================
    // IMAGE PREVIEW
    // ============================================
    if (document.getElementById('bukti')) {
        document.getElementById('bukti').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // ============================================
    // FORM SUBMISSION
    // ============================================
    document.getElementById('reservasiForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validateSlide(3)) return;

        const formData = new FormData(this);

        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        try {
            const response = await fetch(`${API_BASE_URL}/reservasi`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.status) {
                window.location.href = '{{ route('reservasi.success') }}';
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => showError(field, data.errors[field][0]));
                } else {
                    showGeneralError(data.message || 'Terjadi kesalahan');
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            showGeneralError('Terjadi kesalahan koneksi. Silakan coba lagi.');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    // ============================================
    // INITIALIZATION
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const jumlahOrangInput = document.getElementById('jumlah_orang');
        const tanggalInput = document.getElementById('tanggal');
        const ruanganSelect = document.getElementById('ruangan');

        if (!nextBtn) {
            console.error('Tombol nextBtn tidak ditemukan!');
            return;
        }

        nextBtn.addEventListener('click', nextSlide);

        if (prevBtn) {
            prevBtn.addEventListener('click', previousSlide);
        }

        if (jumlahOrangInput) {
            jumlahOrangInput.addEventListener('input', calculateTotal);
        }

        try {
            renderPaketMenu();
            renderRuangan();
            renderFasilitas();
            renderMenuTambahan();
            updateProgress();
            handlePreselectedRoom();
        } catch (err) {
            console.error('Error saat render data:', err);
        }

        if (tanggalInput) {
            const today = new Date().toISOString().split('T')[0];
            tanggalInput.setAttribute('min', today);
            tanggalInput.addEventListener('change', loadAvailableTimeSlots);
        }

        if (ruanganSelect) {
            ruanganSelect.addEventListener('change', function() {
                const selectedRoom = database.ruangan.find(r => r.id == this.value);
                if (selectedRoom) {
                    updateCapacityWarning(selectedRoom.kapasitas);
                }
                loadAvailableTimeSlots();
                calculateTotal();
            });
        }
        
        document.querySelectorAll('.dp-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.dp-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                const percentage = this.dataset.percentage;
                document.getElementById('dp_percentage').value = percentage;
                
                let tipeValue = percentage === '20' ? 'dp_20' : (percentage === '50' ? 'dp_50' : 'full');
                document.getElementById('tipe_pembayaran').value = tipeValue;
                
                updateDpAmount();
            });
        });
    });
</script>

@include('template.footer')