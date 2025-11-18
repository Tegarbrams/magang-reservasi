<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - Luxury Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .luxury-title {
            font-family: 'Playfair Display', serif;
        }

        .gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #F4E5A1 50%, #D4AF37 100%);
        }

        .input-focus:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-content {
            display: none;
        }

        .slide-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-neutral-900 text-white min-h-screen">
    <!-- Navigation -->
    <nav class="flex items-center justify-between px-8 py-6">
        <div class="text-3xl luxury-title font-bold text-yellow-500">LUXURY</div>
        <div class="flex gap-8 items-center">
            <a href="#" class="hover:text-yellow-500 transition">Beranda</a>
            <a href="#" class="hover:text-yellow-500 transition">Fasilitas</a>
            <a href="#" class="hover:text-yellow-500 transition">Kontak Kami</a>
            <a href="#" class="text-yellow-500 font-semibold">Reservasi</a>
            <button class="gold-gradient text-black px-6 py-2 rounded font-semibold hover:opacity-90 transition">Login</button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-8 py-16 max-w-4xl">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm text-neutral-400">Langkah <span id="currentStep">1</span> dari 3</span>
            </div>
            <div class="flex gap-4">
                <div class="flex-1 h-2 bg-yellow-500 rounded-full" id="step1Progress"></div>
                <div class="flex-1 h-2 bg-neutral-700 rounded-full" id="step2Progress"></div>
                <div class="flex-1 h-2 bg-neutral-700 rounded-full" id="step3Progress"></div>
            </div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="hidden bg-green-900 border border-green-700 text-green-100 px-6 py-4 rounded-lg mb-8">
            <p class="font-semibold">✓ Reservasi Berhasil!</p>
            <p class="text-sm">Kami akan menghubungi Anda segera untuk mengkonfirmasi pemesanan.</p>
        </div>

        <!-- Form Container -->
        <div class="bg-neutral-800 rounded-2xl p-8 border border-neutral-700">
            
            <form id="reservasiForm" method="POST" action="{{ route('reservasi.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- SLIDE 1: IDENTITAS -->
                <div class="slide-content active fade-in" id="slide1">
                    <h2 class="luxury-title text-3xl font-bold mb-2">Informasi Identitas</h2>
                    <p class="text-neutral-400 mb-6">Silakan isi data diri Anda dengan lengkap</p>

                    <div class="space-y-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama" class="block text-sm font-medium mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="nama" 
                                name="nama"
                                value="{{ old('nama') }}"
                                class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                                placeholder="Masukkan nama lengkap Anda"
                            >
                            @error('nama')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                        </div>

                        <!-- No HP -->
                        <div>
                            <label for="no_hp" class="block text-sm font-medium mb-2">Nomor Handphone <span class="text-red-500">*</span></label>
                            <input 
                                type="tel" 
                                id="no_hp" 
                                name="no_hp"
                                value="{{ old('no_hp') }}"
                                class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                                placeholder="08123456789"
                            >
                            @error('no_hp')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2">Email <span class="text-red-500">*</span></label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                                placeholder="email@example.com"
                            >
                            @error('email')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 2: PEMILIHAN LAYANAN -->
                <div class="slide-content fade-in" id="slide2">
                    <h2 class="luxury-title text-3xl font-bold mb-2">Pilih Paket & Layanan</h2>
                    <p class="text-neutral-400 mb-6">Pilih paket, ruangan, dan fasilitas yang Anda inginkan</p>

                    <div class="space-y-6">
                        <!-- Paket Menu -->
                        <div>
                            <label class="block text-sm font-medium mb-3">Paket Menu <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="paketContainer">
                                <!-- Diisi oleh JavaScript dari database -->
                            </div>
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                            <input type="hidden" id="paket_menu" name="paket_menu" value="{{ old('paket_menu') }}">
                        </div>

                        <!-- Ruangan -->
                        <div>
                            <label for="ruangan" class="block text-sm font-medium mb-3">Ruangan <span class="text-red-500">*</span></label>
                            <select 
                                id="ruangan" 
                                name="ruangan"
                                class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white input-focus outline-none transition"
                            >
                                <option value="">Pilih ruangan</option>
                                <!-- Diisi oleh JavaScript dari database -->
                            </select>
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                        </div>

                        <!-- Jam Check-in -->
                        <div>
                            <label for="jam_check_in" class="block text-sm font-medium mb-3">Jam Check-in <span class="text-red-500">*</span></label>
                            <select 
                                id="jam_check_in" 
                                name="jam_check_in"
                                class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white input-focus outline-none transition"
                            >
                                <option value="">Pilih jam</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                            </select>
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                        </div>

                        <!-- Fasilitas Tambahan -->
                        <div>
                            <label class="block text-sm font-medium mb-3">Fasilitas Tambahan</label>
                            <div class="space-y-2" id="fasilitasContainer">
                                <!-- Diisi oleh JavaScript dari database -->
                            </div>
                        </div>

                        <!-- Menu Tambahan -->
                        <div>
                            <label class="block text-sm font-medium mb-3">Menu Tambahan (Opsional)</label>
                            <div class="space-y-2" id="menuTambahanContainer">
                                <!-- Diisi oleh JavaScript dari database -->
                            </div>
                        </div>

                        <!-- Total Harga -->
                        <div class="bg-gradient-to-r from-yellow-500/20 to-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold">Total Harga:</span>
                                <span id="totalHarga" class="text-2xl font-bold text-yellow-500">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 3: PEMBAYARAN -->
                <div class="slide-content fade-in" id="slide3">
                    <h2 class="luxury-title text-3xl font-bold mb-2">Pembayaran</h2>
                    <p class="text-neutral-400 mb-6">Lakukan pembayaran melalui QRIS dan unggah bukti pembayaran</p>

                    <div class="space-y-6">
                        <!-- Ringkasan Pesanan -->
                        <div class="bg-neutral-700 rounded-lg p-6 mb-6">
                            <h3 class="font-semibold mb-4">Ringkasan Pesanan</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Nama:</span>
                                    <span id="summaryNama">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Paket:</span>
                                    <span id="summaryPaket">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Ruangan:</span>
                                    <span id="summaryRuangan">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Jam:</span>
                                    <span id="summaryJam">-</span>
                                </div>
                                <hr class="border-neutral-600 my-2">
                                <div class="flex justify-between text-lg font-bold text-yellow-500">
                                    <span>Total:</span>
                                    <span id="summaryTotal">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- QRIS Payment Section -->
                        <div class="border-2 border-dashed border-yellow-500 rounded-lg p-6 text-center bg-yellow-500/5">
                            <h3 class="font-semibold mb-4">Scan QRIS untuk Pembayaran</h3>
                            <div class="bg-white p-4 rounded-lg inline-block mb-4">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://luxury-hotel.test/pembayaran/{{ uniqid() }}" alt="QRIS Code" class="w-64 h-64">
                            </div>
                            <p class="text-sm text-neutral-400">Jumlah pembayaran: <span id="qrisAmount" class="text-yellow-500 font-semibold">Rp 0</span></p>
                        </div>

                        <!-- Upload Bukti Pembayaran -->
                        <div>
                            <label for="bukti_pembayaran" class="block text-sm font-medium mb-2">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-neutral-600 rounded-lg p-6 text-center cursor-pointer hover:border-yellow-500 transition" id="uploadArea">
                                <input 
                                    type="file" 
                                    id="bukti_pembayaran" 
                                    name="bukti_pembayaran"
                                    accept="image/*"
                                    class="hidden"
                                >
                                <p class="text-neutral-400 mb-2">Drag file di sini atau klik untuk memilih</p>
                                <p class="text-xs text-neutral-500">Format: JPG, PNG (Max 2MB)</p>
                                <p id="fileName" class="text-sm text-yellow-500 mt-2 hidden"></p>
                            </div>
                            <p class="error-text text-red-400 text-sm mt-2 hidden"></p>
                        </div>

                        <!-- Catatan Tambahan -->
                        <div>
                            <label for="catatan" class="block text-sm font-medium mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea 
                                id="catatan" 
                                name="catatan"
                                rows="4"
                                class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                                placeholder="Tuliskan permintaan khusus atau catatan tambahan di sini..."
                            ></textarea>
                        </div>

                        <!-- Persetujuan -->
                        <div class="flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                id="setuju" 
                                name="setuju"
                                class="w-4 h-4 mt-1"
                            >
                            <label for="setuju" class="text-sm text-neutral-300">
                                Saya menyetujui <a href="#" class="text-yellow-500 hover:underline">syarat dan ketentuan</a> serta <a href="#" class="text-yellow-500 hover:underline">kebijakan privasi</a> Luxury Hotel
                            </label>
                        </div>
                        <p class="error-text text-red-400 text-sm hidden" id="setujuError"></p>
                    </div>
                </div>

                <!-- Navigation Buttons - SUDAH DIHAPUS ONCLICK -->
                <div class="flex gap-4 mt-8 pt-6 border-t border-neutral-700">
                    <button 
                        type="button" 
                        id="prevBtn"
                        class="flex-1 px-6 py-3 border border-neutral-600 rounded-lg hover:border-yellow-500 transition font-semibold disabled:opacity-50"
                    >
                        ← Kembali
                    </button>
                    <button 
                        type="button" 
                        id="nextBtn"
                        class="flex-1 gold-gradient text-black px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold"
                    >
                        Lanjut →
                    </button>
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="hidden flex-1 gold-gradient text-black px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold"
                    >
                        ✓ Kirim Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ============================================
        // DEKLARASI VARIABEL GLOBAL
        // ============================================
        let currentSlide = 1;
        const totalSlides = 3;

        // Data dari server
        const database = {
            paket_menu: @json($paketMenu ?? []),
            ruangan: @json($ruangan ?? []),
            fasilitas: @json($fasilitas ?? []),
            menu_tambahan: @json($menuTambahan ?? []),
            reservasi_ruangan: @json($reservasiRuangan ?? [])
        };

        // ============================================
        // RENDER FUNCTIONS
        // ============================================
        function renderPaketMenu() {
            const container = document.getElementById('paketContainer');
            if (database.paket_menu.length === 0) {
                container.innerHTML = '<p class="text-neutral-400 col-span-2">Tidak ada paket tersedia</p>';
                return;
            }
            container.innerHTML = database.paket_menu.map(menu => `
                <button 
                    type="button"
                    onclick="selectPaket(${menu.id})"
                    class="p-4 rounded-lg text-left border transition ${
                        menu.stock === 0 
                        ? 'bg-neutral-700 border-neutral-600 cursor-not-allowed opacity-50' 
                        : 'bg-neutral-700 border-neutral-600 hover:border-yellow-500'
                    }"
                    ${menu.stock === 0 ? 'disabled' : ''}
                    id="paket-${menu.id}"
                >
                    <p class="font-semibold">${menu.nama}</p>
                    <p class="text-sm">Rp ${Number(menu.harga).toLocaleString('id-ID')}</p>
                    <p class="text-xs mt-1 ${menu.stock === 0 ? 'text-red-400' : 'text-green-400'}">
                        ${menu.stock === 0 ? '✗ Tidak Tersedia' : `✓ ${menu.stock} tersedia`}
                    </p>
                </button>
            `).join('');
        }

        function renderRuangan() {
            const select = document.getElementById('ruangan');
            if (database.ruangan.length === 0) {
                select.innerHTML = '<option value="">Tidak ada ruangan tersedia</option>';
                return;
            }
            select.innerHTML = '<option value="">Pilih ruangan</option>' + database.ruangan.map(ruang => `
                <option value="${ruang.id}">
                    ${ruang.nama} - Kapasitas: ${ruang.kapasitas} (Rp ${Number(ruang.harga).toLocaleString('id-ID')})
                </option>
            `).join('');
        }

        function renderFasilitas() {
            const container = document.getElementById('fasilitasContainer');
            if (database.fasilitas.length === 0) {
                container.innerHTML = '<p class="text-neutral-400">Tidak ada fasilitas tersedia</p>';
                return;
            }
            container.innerHTML = database.fasilitas.map(fas => `
                <label class="flex items-center gap-3 p-3 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600">
                    <input 
                        type="checkbox" 
                        name="fasilitas[]" 
                        value="${fas.id}"
                        onchange="calculateTotal()"
                        class="w-4 h-4"
                    >
                    <div class="flex-1">
                        <p class="font-medium">${fas.nama}</p>
                        <p class="text-sm text-neutral-300">Rp ${Number(fas.harga).toLocaleString('id-ID')}</p>
                    </div>
                </label>
            `).join('');
        }

        function renderMenuTambahan() {
            const container = document.getElementById('menuTambahanContainer');
            if (database.menu_tambahan.length === 0) {
                container.innerHTML = '<p class="text-neutral-400">Tidak ada menu tambahan tersedia</p>';
                return;
            }
            container.innerHTML = database.menu_tambahan.map(menu => `
                <label class="flex items-center gap-3 p-3 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600">
                    <input 
                        type="checkbox" 
                        name="menu_tambahan[]" 
                        value="${menu.id}"
                        onchange="calculateTotal()"
                        class="w-4 h-4"
                    >
                    <div class="flex-1">
                        <p class="font-medium">${menu.nama}</p>
                        <p class="text-sm text-neutral-300">Rp ${Number(menu.harga).toLocaleString('id-ID')}</p>
                    </div>
                </label>
            `).join('');
        }

        function selectPaket(id) {
            document.getElementById('paket_menu').value = id;
            document.querySelectorAll('#paketContainer button').forEach(btn => {
                btn.classList.remove('bg-yellow-500', 'text-black', 'border-yellow-600');
                btn.classList.add('bg-neutral-700', 'border-neutral-600');
            });
            const selectedBtn = document.getElementById('paket-' + id);
            selectedBtn.classList.add('bg-yellow-500', 'text-black', 'border-yellow-600');
            selectedBtn.classList.remove('bg-neutral-700', 'border-neutral-600');
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;

            // Paket menu
            const paketId = document.getElementById('paket_menu').value;
            if (paketId) {
                const paket = database.paket_menu.find(p => p.id == paketId);
                if (paket) total += Number(paket.harga);
            }

            // Ruangan
            const ruanganId = document.getElementById('ruangan').value;
            if (ruanganId) {
                const ruang = database.ruangan.find(r => r.id == ruanganId);
                if (ruang) total += Number(ruang.harga);
            }

            // Fasilitas
            document.querySelectorAll('input[name="fasilitas[]"]:checked').forEach(cb => {
                const fas = database.fasilitas.find(f => f.id == cb.value);
                if (fas) total += Number(fas.harga);
            });

            // Menu tambahan
            document.querySelectorAll('input[name="menu_tambahan[]"]:checked').forEach(cb => {
                const menu = database.menu_tambahan.find(m => m.id == cb.value);
                if (menu) total += Number(menu.harga);
            });

            document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('qrisAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // ============================================
        // VALIDATION FUNCTIONS
        // ============================================
        function clearErrors() {
            document.querySelectorAll('.error-text').forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });
        }

        function showError(fieldName, message) {
            const field = document.getElementById(fieldName);
            if (!field) return;
            
            const errorElement = field.closest('div').querySelector('.error-text');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }
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
                } else if (!/^08\d{8,11}$/.test(no_hp)) {
                    showError('no_hp', 'Format nomor tidak valid (08xxxxxxxxx)');
                    isValid = false;
                }
                if (!email) {
                    showError('email', 'Email harus diisi');
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showError('email', 'Format email tidak valid');
                    isValid = false;
                }

                if (isValid) {
                    document.getElementById('summaryNama').textContent = nama;
                }
            }

            if (slide === 2) {
                const paket = document.getElementById('paket_menu').value;
                const ruangan = document.getElementById('ruangan').value;
                const jam = document.getElementById('jam_check_in').value;

                if (!paket) {
                    showError('paket_menu', 'Paket menu harus dipilih');
                    isValid = false;
                } else {
                    const selectedPaket = database.paket_menu.find(p => p.id == paket);
                    if (selectedPaket && selectedPaket.stock === 0) {
                        showError('paket_menu', 'Paket ini tidak tersedia (stock habis)');
                        isValid = false;
                    } else if (isValid && selectedPaket) {
                        document.getElementById('summaryPaket').textContent = selectedPaket.nama;
                    }
                }

                if (!ruangan) {
                    showError('ruangan', 'Ruangan harus dipilih');
                    isValid = false;
                } else {
                    const selectedRuangan = database.ruangan.find(r => r.id == ruangan);
                    if (isValid && selectedRuangan) {
                        document.getElementById('summaryRuangan').textContent = selectedRuangan.nama;
                    }
                }

                if (!jam) {
                    showError('jam_check_in', 'Jam check-in harus dipilih');
                    isValid = false;
                } else {
                    const isBooked = database.reservasi_ruangan.some(res => 
                        res.ruangan == parseInt(ruangan) && res.jam_check_in === jam
                    );
                    if (isBooked) {
                        showError('jam_check_in', 'Ruangan sudah dipesan di jam tersebut');
                        isValid = false;
                    } else if (isValid) {
                        document.getElementById('summaryJam').textContent = jam;
                    }
                }
            }

            if (slide === 3) {
                const bukti = document.getElementById('bukti_pembayaran').files.length;
                const setuju = document.getElementById('setuju').checked;

                if (bukti === 0) {
                    showError('bukti_pembayaran', 'Bukti pembayaran harus diunggah');
                    isValid = false;
                }

                if (!setuju) {
                    const errorEl = document.getElementById('setujuError');
                    if (errorEl) {
                        errorEl.textContent = 'Anda harus menyetujui syarat dan ketentuan';
                        errorEl.classList.remove('hidden');
                    }
                    isValid = false;
                }
            }

            return isValid;
        }

        // ============================================
        // NAVIGATION FUNCTIONS
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
            document.querySelectorAll('.slide-content').forEach(el => {
                el.classList.remove('active');
            });
            document.getElementById('slide' + slide).classList.add('active');

            // Update button visibility
            document.getElementById('prevBtn').style.display = slide === 1 ? 'none' : 'block';
            document.getElementById('nextBtn').style.display = slide === totalSlides ? 'none' : 'block';
            document.getElementById('submitBtn').style.display = slide === totalSlides ? 'block' : 'none';

            // Summary update
            if (slide === 3) {
                calculateTotal();
            }
        }

        function updateProgress() {
            document.getElementById('currentStep').textContent = currentSlide;
            
            document.getElementById('step1Progress').style.backgroundColor = currentSlide >= 1 ? '#EAB308' : '#525252';
            document.getElementById('step2Progress').style.backgroundColor = currentSlide >= 2 ? '#EAB308' : '#525252';
            document.getElementById('step3Progress').style.backgroundColor = currentSlide >= 3 ? '#EAB308' : '#525252';

            document.getElementById('prevBtn').disabled = currentSlide === 1;
        }

        // ============================================
        // UPLOAD FILE HANDLING
        // ============================================
        document.getElementById('uploadArea').addEventListener('click', function() {
            document.getElementById('bukti_pembayaran').click();
        });

        document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                document.getElementById('fileName').textContent = '✓ ' + e.target.files[0].name;
                document.getElementById('fileName').classList.remove('hidden');
            }
        });

        document.getElementById('uploadArea').addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#D4AF37';
        });

        document.getElementById('uploadArea').addEventListener('dragleave', function(e) {
            this.style.borderColor = '#525252';
        });

        document.getElementById('uploadArea').addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('bukti_pembayaran').files = files;
                document.getElementById('fileName').textContent = '✓ ' + files[0].name;
                document.getElementById('fileName').classList.remove('hidden');
            }
            this.style.borderColor = '#525252';
        });

        // ============================================
        // FORM SUBMISSION
        // ============================================
        document.getElementById('reservasiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validateSlide(3)) return;

            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Memproses...';

            fetch('{{ route("reservasi.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = '{{ route("reservasi.index") }}';
                    }, 2000);
                } else {
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });

        // ============================================
        // INITIALIZE - INI YANG PENTING!
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== Page Loaded - Initializing ===');
            console.log('Database loaded:', database);
            
            // Attach event listeners to buttons - INI YANG MEMBUAT TOMBOL BEKERJA!
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            
            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Next button clicked');
                    nextSlide();
                });
                console.log('✓ Next button event listener attached');
            } else {
                console.error('❌ Next button not found!');
            }
            
            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Previous button clicked');
                    previousSlide();
                });
                console.log('✓ Previous button event listener attached');
            } else {
                console.error('❌ Previous button not found!');
            }
            
            // Render all data
            renderPaketMenu();
            renderFasilitas();
            renderMenuTambahan();
            renderRuangan();
            updateProgress();
            
            console.log('=== Initialization Complete ===');
        });
    </script>
</body>
</html>