@include('template.header')
<link rel="stylesheet" href="{{ asset('css/reservasi.css') }}">


<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    :root {
        --gold-primary: #D4AF37;
        --gold-light: #F4E5C3;
        --gold-dark: #B8941F;
        --white: #FFFFFF;
        --black: #1A1A1A;
        --gray-50: #FAFAFA;
        --gray-100: #F5F5F5;
        --gray-200: #E5E5E5;
        --gray-300: #D4D4D4;
        --gray-600: #525252;
        --gray-700: #404040;
        --shadow-sm: 0 1px 2px 0 rgba(212, 175, 55, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(212, 175, 55, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(212, 175, 55, 0.15);
        --shadow-xl: 0 20px 25px -5px rgba(212, 175, 55, 0.2);
    }

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    body {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
        color: var(--black);
    }

    /* Main Section */
    section {
        min-height: 100vh;
        padding: 3rem 0;
        background: var(--white);
    }

    .container {
        max-width: 1000px;
    }

    /* Header */
    h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.75rem;
        letter-spacing: -0.01em;
    }

    /* Progress Bar */
    .progress-container {
        background: var(--white);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid var(--gray-200);
        margin-bottom: 2rem;
    }

    .progress-steps {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .progress-step {
        flex: 1;
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-step.active {
        background: var(--gold-primary);
    }

    .progress-step.active::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    #currentStep {
        font-weight: 600;
        color: var(--gold-primary);
    }

    /* Form Container */
    #reservasiForm {
        background: var(--white);
        padding: 2.5rem;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
    }

    /* Cards */
    .paket-card,
    .dp-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }

    .paket-card:hover:not(.disabled),
    .dp-card:hover {
        border-color: var(--gold-primary);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .paket-card.selected,
    .dp-card.selected {
        border-color: var(--gold-primary);
        background: linear-gradient(135deg, var(--white) 0%, var(--gold-light) 100%);
        box-shadow: var(--shadow-lg);
    }

    .paket-card.selected::before,
    .dp-card.selected::before {
        content: '✓';
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 24px;
        height: 24px;
        background: var(--gold-primary);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .paket-card.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--gray-50);
    }

    .paket-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    /* Selected Room Card */
    .selected-room-card {
        background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
        color: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .room-locked-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
    }

    /* Time Slots */
    .time-slot {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        font-weight: 500;
    }

    .time-slot:hover:not(.blocked) {
        border-color: var(--gold-primary);
        background: var(--gold-light);
    }

    .time-slot.selected {
        background: var(--gold-primary);
        border-color: var(--gold-primary);
        color: var(--white);
        font-weight: 600;
    }

    .time-slot.blocked {
        background: var(--gray-100);
        border-color: var(--gray-300);
        color: var(--gray-600);
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* DP Cards */
    .dp-card .badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        background: var(--gold-light);
        color: var(--gold-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dp-card .badge.recommended {
        background: var(--gold-primary);
        color: var(--white);
    }

    .dp-card h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--black);
    }

    .dp-card p {
        font-size: 1rem;
        color: var(--gray-600);
        margin: 0;
    }

    /* Form Controls */
    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
        background: var(--white);
        color: var(--black);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--gold-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        background: var(--white);
    }

    .form-control::placeholder {
        color: var(--gray-600);
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-warning {
        background: var(--gold-primary);
        color: var(--white);
    }

    .btn-warning:hover {
        background: var(--gold-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-success {
        background: var(--gold-primary);
        color: var(--white);
    }

    .btn-success:hover {
        background: var(--gold-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--black);
        border: 1px solid var(--gray-200);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-300);
    }

    .btn-light {
        background: var(--white);
        color: var(--gold-primary);
        border: 1px solid var(--gold-primary);
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .btn-light:hover {
        background: var(--gold-light);
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
        padding: 1rem 1.25rem;
        border: 1px solid;
        font-size: 0.9375rem;
    }

    .alert-warning {
        background: var(--gold-light);
        border-color: var(--gold-primary);
        color: var(--gold-dark);
    }

    .alert-info {
        background: var(--gold-light);
        border-color: var(--gold-primary);
        color: var(--black);
    }

    .alert-danger {
        background: #FEE2E2;
        border-color: #EF4444;
        color: #991B1B;
    }

    /* Slide Animation */
    .slide-content {
        display: none;
    }

    .slide-content.active {
        display: block;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Image Preview */
    .img-thumbnail {
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 0.5rem;
        max-width: 100%;
        height: auto;
    }

    /* Text Utilities */
    .text-muted {
        color: var(--gray-600);
        font-size: 0.9375rem;
    }

    .text-success {
        color: var(--gold-primary);
    }

    .text-danger {
        color: #EF4444;
    }

    .fw-bold {
        font-weight: 700;
    }

    .fw-semibold {
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #reservasiForm {
            padding: 1.5rem;
        }

        .progress-container {
            padding: 1rem;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn {
            width: 100%;
        }

        .d-flex.gap-3 {
            flex-direction: column;
            gap: 0.75rem !important;
        }
    }

    /* Loading State */
    .spinner-border {
        width: 1.25rem;
        height: 1.25rem;
        border-width: 2px;
        border-color: currentColor;
        border-right-color: transparent;
    }

    /* Focus Visible */
    *:focus-visible {
        outline: 2px solid var(--gold-primary);
        outline-offset: 2px;
    }
</style>

<section>
    <div class="container">
        <div class="text-center mb-4">
            <h2>Reservasi Tempat</h2>
            <p class="text-muted">Lengkapi formulir di bawah untuk melakukan reservasi</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="d-flex justify-content-between align-items-center">
                <span style="color: var(--gray-600); font-size: 0.875rem;">Langkah <span id="currentStep">1</span> dari
                    3</span>
            </div>
            <div class="progress-steps">
                <div class="progress-step active" id="step1Progress"></div>
                <div class="progress-step" id="step2Progress"></div>
                <div class="progress-step" id="step3Progress"></div>
            </div>
        </div>

        <div id="errorMessage" class="alert alert-danger d-none mb-3">
            <p class="fw-bold mb-1">Error!</p>
            <p class="mb-0" id="errorText"></p>
        </div>

        <!-- Form Container -->
        <form id="reservasiForm">
            <!-- SLIDE 1: IDENTITAS -->
            <div class="slide-content active" id="slide1">
                <h3>Informasi Identitas</h3>
                <p class="text-muted mb-4">Silakan isi data diri Anda dengan lengkap</p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            placeholder="Masukkan nama lengkap" required>
                        <div class="text-danger small mt-1 d-none" id="error-nama"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_hp" class="form-label">Nomor Handphone *</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control"
                            placeholder="08xxxxxxxxxx" required>
                        <div class="text-danger small mt-1 d-none" id="error-no_hp"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="nama@email.com" required>
                        <div class="text-danger small mt-1 d-none" id="error-email"></div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 2: LAYANAN -->
            <div class="slide-content" id="slide2">
                <h3>Pilih Paket & Layanan</h3>

                <!-- Selected Room Display -->
                <div id="selectedRoomDisplay" class="d-none">
                    <div class="selected-room-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="room-locked-badge">🔒 Ruangan Terpilih</span>
                            <a href="/reservasi" class="btn btn-light">Ganti</a>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <h4 class="fw-bold mb-2" style="color: white;" id="selectedRoomName">-</h4>
                                <p class="mb-1" style="font-size: 0.9375rem;">📍 Kapasitas: <span
                                        id="selectedRoomCapacity">-</span> orang</p>
                                <p class="mb-0" style="font-size: 0.9375rem;">💰 Harga: Rp <span
                                        id="selectedRoomPrice">-</span></p>
                            </div>
                            <div class="col-md-3 text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                    fill="rgba(255,255,255,0.5)" viewBox="0 0 16 16">
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
                        <label class="form-label">Pilih Paket Menu *</label>
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
                        <label class="form-label">Pilih Jam Check-in *</label>
                        <input type="hidden" name="jam" id="jam" required>
                        <div class="text-danger small mt-1 d-none" id="error-jam"></div>
                        <div id="timeSlotsContainer" class="row g-2">
                            <div class="col-12 text-center text-muted py-4">
                                Pilih tanggal dan ruangan terlebih dahulu
                            </div>
                        </div>
                    </div>

                    <!-- INFO DURASI RESERVASI - TAMBAHKAN INI -->
                    <div class="alert"
                        style="background: linear-gradient(135deg, var(--gold-light) 0%, var(--white) 100%); border: 1px solid var(--gold-primary); margin-top: 0.75rem; margin-bottom: 0.75rem;">
                        <div class="d-flex align-items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="var(--gold-dark)" viewBox="0 0 16 16" style="flex-shrink: 0; margin-top: 2px;">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                            <div style="flex: 1;">
                                <p class="mb-1 fw-semibold" style="color: var(--gold-dark); font-size: 0.9375rem;">
                                    ℹ️ Informasi Durasi Reservasi
                                </p>
                                <p class="mb-0"
                                    style="color: var(--gray-700); font-size: 0.875rem; line-height: 1.5;">
                                    Jam yang Anda pilih adalah <strong>jam check-in</strong>. Durasi reservasi otomatis
                                    adalah <strong>2 jam</strong> dari waktu check-in yang dipilih.
                                    <br>
                                    <span class="text-muted small">Contoh: Jika memilih check-in jam 10:00, maka
                                        reservasi berlaku hingga jam 12:00</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR INFO DURASI -->

                    <!-- Jumlah Orang -->
                    <div class="col-md-12 mb-3">
                        <label for="jumlah_orang" class="form-label">Jumlah Orang *</label>
                        <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control"
                            min="1" placeholder="Masukkan jumlah orang" required>
                        <small class="text-muted" id="capacityWarning"></small>
                        <div class="text-danger small mt-1 d-none" id="error-jumlah_orang"></div>
                    </div>

                    <!-- Fasilitas Tambahan -->
                    <div class="col-12 mb-3">
                        <label class="form-label">Fasilitas Tambahan (Opsional)</label>
                        <div id="fasilitasContainer" class="row g-2"></div>
                    </div>

                    <!-- Menu Tambahan -->
                    <div class="col-12 mb-3">
                        <label class="form-label">Menu Tambahan (Opsional)</label>
                        <div id="menuTambahanContainer" class="row g-2"></div>
                    </div>

                    <!-- Catatan -->
                    <div class="col-12 mb-3">
                        <label for="pesan" class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea name="pesan" id="pesan" class="form-control" rows="3"
                            placeholder="Tambahkan catatan khusus..."></textarea>
                    </div>

                    <!-- Total Harga -->
                    <div class="col-12 mb-3">
                        <div class="alert alert-warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total Harga:</span>
                                <span id="totalHarga"
                                    style="font-size: 1.5rem; font-weight: 700; color: var(--gold-dark);">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3: PEMBAYARAN -->
            <div class="slide-content" id="slide3">
                <h3>Pembayaran</h3>
                <p class="text-muted mb-4">Pilih metode DP dan unggah bukti pembayaran</p>

                <!-- Pilihan DP -->
                <div class="mb-4">
                    <label class="form-label">Pilih DP *</label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="dp-card" data-percentage="20">
                                <div class="badge">20%</div>
                                <h4>DP Minimal</h4>
                                <p id="dp20Amount">Rp 0</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dp-card" data-percentage="50">
                                <div class="badge recommended">Rekomendasi</div>
                                <h4>50%</h4>
                                <p id="dp50Amount">Rp 0</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dp-card" data-percentage="100">
                                <div class="badge">Lunas</div>
                                <h4>100%</h4>
                                <p id="fullAmount">Rp 0</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="dp_percentage" id="dp_percentage" required>
                    <input type="hidden" name="tipe_pembayaran" id="tipe_pembayaran">
                    <div class="text-danger small mt-1 d-none" id="error-dp_percentage"></div>
                </div>

                <!-- Total dan DP Preview -->
                <div class="alert alert-info mb-4 d-none" id="selectedPaymentInfo">
                    <h5 class="fw-semibold mb-3">Detail Pembayaran:</h5>
                    <p class="mb-1">Metode: <span id="infoMetode">-</span></p>
                    <p class="mb-1">Jumlah Bayar: <span id="infoJumlah" class="fw-bold"
                            style="color: var(--gold-dark);">Rp 0</span></p>
                    <p class="mb-0">Sisa Bayar: <span id="infoSisa">Rp 0</span></p>
                    <hr style="margin: 1rem 0; border-color: var(--gold-primary); opacity: 0.3;">
                    <p class="mb-1">🕐 Check-in: <span id="infoCheckin" class="fw-semibold">-</span></p>
                    <p class="mb-0">🕐 Check-out (estimasi): <span id="infoCheckout" class="fw-semibold">-</span>
                    </p>
                </div>

                <div class="mb-4">
                    <div
                        style="background: var(--white); border: 1px solid var(--gray-200); border-radius: 12px; padding: 1.5rem;">
                        <h5 class="fw-semibold mb-3" style="color: var(--black);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="var(--gold-primary)" viewBox="0 0 16 16"
                                style="margin-right: 0.5rem; vertical-align: middle;">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                            </svg>
                            Scan QRIS untuk Pembayaran
                        </h5>

                        <div class="text-center">
                            <!-- QRIS Image Container -->
                            <div
                                style="background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%); border: 2px dashed var(--gold-primary); border-radius: 12px; padding: 1.5rem; display: inline-block; max-width: 100%;">
                                <img src="{{ asset('img/qris.png') }}" alt="QRIS Payment"
                                    style="max-width: 280px; width: 100%; height: auto; border-radius: 8px; box-shadow: var(--shadow-md);">

                                <div class="mt-3"
                                    style="background: var(--gold-light); border-radius: 8px; padding: 0.75rem; margin-top: 1rem;">
                                    <p class="mb-1 fw-semibold" style="color: var(--gold-dark); font-size: 0.875rem;">
                                        📱 Cara Pembayaran:
                                    </p>
                                    <ol class="mb-0 text-start"
                                        style="color: var(--gray-700); font-size: 0.8125rem; padding-left: 1.25rem; line-height: 1.6;">
                                        <li>Buka aplikasi mobile banking atau e-wallet Anda</li>
                                        <li>Pilih menu <strong>Scan QR</strong> atau <strong>QRIS</strong></li>
                                        <li>Scan kode QR di atas</li>
                                        <li>Masukkan nominal sesuai yang tertera di Detail Pembayaran</li>
                                        <li>Konfirmasi dan selesaikan pembayaran</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3 mb-0" style="font-size: 0.875rem;">
                                <strong>⚠️ Penting:</strong> Pastikan nominal yang Anda transfer sesuai dengan
                                <strong>Jumlah Bayar</strong> di atas, lalu upload bukti pembayaran di bawah ini.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Bukti -->
                <div class="mb-3">
                    <label for="bukti" class="form-label">Upload Bukti Pembayaran *</label>
                    <input type="file" name="bukti" id="bukti" class="form-control" accept="image/*"
                        required>
                    <div class="text-danger small mt-1 d-none" id="error-bukti"></div>
                    <div id="imagePreview" class="mt-3 d-none">
                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail"
                            style="max-width: 300px;">
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="button" id="prevBtn" class="btn btn-secondary d-none">← Kembali</button>
                <button type="button" id="nextBtn" class="btn btn-warning">Lanjut →</button>
                <button type="submit" id="submitBtn" class="btn btn-success d-none">✓ Kirim Reservasi</button>
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
                <!-- ← GUNAKAN GAMBAR DARI DATABASE -->
               <img src="${menu.gambar ? '/' + menu.gambar : '{{ asset('img/paket1.jpg') }}'}" 
     class="card-img-top paket-img" 
     alt="${menu.nama}">
                <div class="card-body text-center">
                    <h5 class="card-title">${menu.nama}</h5>
                    <!-- ← TAMBAHKAN DESKRIPSI -->
                    <p class="card-text small text-muted mb-2">${menu.deskripsi || 'Paket makanan spesial'}</p>
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
            <div class="form-check p-3 border rounded menu-item" id="menu-item-${menu.id}">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">
                        <input class="form-check-input menu-checkbox me-2" 
                               type="checkbox" 
                               value="${menu.id}" 
                               id="menu-${menu.id}" 
                               onchange="toggleQtyInput(${menu.id})">
                        <label class="form-check-label fw-semibold" for="menu-${menu.id}">
                            ${menu.nama}
                        </label>
                    </div>
                </div>
                <div class="small text-muted mb-2">Rp ${Number(menu.harga).toLocaleString('id-ID')} / porsi</div>
                
                <!-- Qty Input (Hidden by default) -->
                <div class="qty-controls d-none" id="qty-menu-${menu.id}" style="margin-top: 0.5rem;">
                    <label class="small text-muted d-block mb-1">Jumlah:</label>
                    <div class="input-group input-group-sm" style="max-width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty(${menu.id})">-</button>
                        <input type="number" 
                               class="form-control text-center qty-input" 
                               id="qty-input-menu-${menu.id}" 
                               value="1" 
                               min="1" 
                               max="99"
                               onchange="calculateTotal()">
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty(${menu.id})">+</button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
    }

    function toggleQtyInput(id) {
        const checkbox = document.getElementById(`menu-${id}`);
        const qtyControl = document.getElementById(`qty-menu-${id}`);

        if (checkbox.checked) {
            qtyControl.classList.remove('d-none');
        } else {
            qtyControl.classList.add('d-none');
            document.getElementById(`qty-input-menu-${id}`).value = 1;
        }

        calculateTotal();
    }

    // 🔧 INCREASE QTY
    function increaseQty(id) {
        const input = document.getElementById(`qty-input-menu-${id}`);
        const currentVal = parseInt(input.value) || 1;
        if (currentVal < 99) {
            input.value = currentVal + 1;
            calculateTotal();
        }
    }

    // 🔧 DECREASE QTY
    function decreaseQty(id) {
        const input = document.getElementById(`qty-input-menu-${id}`);
        const currentVal = parseInt(input.value) || 1;
        if (currentVal > 1) {
            input.value = currentVal - 1;
            calculateTotal();
        }
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

        console.log('Loading time slots...', {
            ruanganId,
            tanggal
        }); // Debug

        if (!ruanganId || !tanggal) {
            container.innerHTML =
                '<div class="col-12 text-center text-muted py-4">Pilih tanggal dan ruangan terlebih dahulu</div>';
            return;
        }

        // Show loading
        container.innerHTML =
            '<div class="col-12 text-center py-4"><div class="spinner-border text-warning"></div></div>';

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
                    container.innerHTML =
                        `<div class="col-12 text-center text-danger py-4">${data.message || 'Gagal memuat jam'}</div>`;
                }
            })
            .catch(err => {
                console.error('Error loading time slots:', err);
                container.innerHTML =
                    '<div class="col-12 text-center text-danger py-4">Gagal memuat data jam. Coba lagi.</div>';
            });
    }

    function renderTimeSlots(available, unavailable) {
        const container = document.getElementById('timeSlotsContainer');
        container.innerHTML = '';

        console.log('Rendering time slots...', {
            available,
            unavailable
        }); // Debug

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

        updateCheckoutInfo(time);
    }

    function updateCheckoutInfo(checkinTime) {
        // Hitung jam checkout (2 jam setelah check-in)
        const [hours, minutes] = checkinTime.split(':');
        const checkoutHour = (parseInt(hours) + 2).toString().padStart(2, '0');
        const checkoutTime = `${checkoutHour}:${minutes}`;

        // Update di halaman pembayaran (slide 3)
        const infoCheckin = document.getElementById('infoCheckin');
        const infoCheckout = document.getElementById('infoCheckout');

        if (infoCheckin) {
            infoCheckin.textContent = checkinTime;
        }
        if (infoCheckout) {
            infoCheckout.textContent = checkoutTime;
        }
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

        document.querySelectorAll('.menu-checkbox:checked').forEach(cb => {
            const menuId = cb.value;
            const menu = database.menu_tambahan.find(m => m.id == menuId);
            const qty = parseInt(document.getElementById(`qty-input-menu-${menuId}`).value) || 1;
            if (menu) {
                total += Number(menu.harga) * qty;
            }
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

        const formData = new FormData();

        // Data identitas
        formData.append('nama', document.getElementById('nama').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('no_hp', document.getElementById('no_hp').value);

        // Data layanan
        formData.append('paket_menu', document.getElementById('paket_menu').value);
        formData.append('ruangan', document.getElementById('ruangan').value);
        formData.append('tanggal', document.getElementById('tanggal').value);
        formData.append('jam', document.getElementById('jam').value);
        formData.append('jumlah_orang', document.getElementById('jumlah_orang').value);
        formData.append('pesan', document.getElementById('pesan').value);

        // Fasilitas (tanpa qty)
        document.querySelectorAll('input[name="fasilitas[]"]:checked').forEach(cb => {
            formData.append('fasilitas[]', cb.value);
        });

        // Menu tambahan dengan QTY (format: "id:qty")
        document.querySelectorAll('.menu-checkbox:checked').forEach(cb => {
            const menuId = cb.value;
            const qty = document.getElementById(`qty-input-menu-${menuId}`).value;
            formData.append('menu_tambahan[]', `${menuId}:${qty}`);
        });

        // Data pembayaran
        formData.append('dp_percentage', document.getElementById('dp_percentage').value);

        const buktiFile = document.getElementById('bukti').files[0];
        if (buktiFile) {
            formData.append('bukti', buktiFile);
        }

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
                document.querySelectorAll('.dp-card').forEach(c => c.classList.remove(
                    'selected'));
                this.classList.add('selected');
                const percentage = this.dataset.percentage;
                document.getElementById('dp_percentage').value = percentage;

                let tipeValue = percentage === '20' ? 'dp_20' : (percentage === '50' ? 'dp_50' :
                    'full');
                document.getElementById('tipe_pembayaran').value = tipeValue;

                updateDpAmount();
            });
        });
    });
</script>

@include('template.footer')
