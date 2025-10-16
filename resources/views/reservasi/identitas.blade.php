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

    <!-- Form Section -->
    <div class="container mx-auto px-8 py-16 max-w-6xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Form -->
            <div class="bg-neutral-800 rounded-2xl p-8 border border-neutral-700">
                <h1 class="luxury-title text-4xl font-bold mb-2">
                    Reservasi <span class="text-yellow-500">Sekarang</span>
                </h1>
                <p class="text-neutral-400 mb-8">Isi formulir di bawah ini untuk melakukan reservasi</p>

                <!-- Success Message -->
                <div id="successMessage" class="hidden bg-green-900 border border-green-700 text-green-100 px-4 py-3 rounded-lg mb-6">
                    <p class="font-semibold">Reservasi Berhasil!</p>
                    <p class="text-sm">Kami akan menghubungi Anda segera.</p>
                </div>

                <form id="reservasiForm" class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            required
                            class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                            placeholder="Masukkan nama lengkap Anda"
                        >
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium mb-2">Nomor Handphone</label>
                        <input 
                            type="tel" 
                            id="no_hp" 
                            name="no_hp" 
                            required
                            class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                            placeholder="08123456789"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white placeholder-neutral-500 input-focus outline-none transition"
                            placeholder="email@example.com"
                        >
                    </div>

                    <!-- Paket Menu -->
                    <div>
                        <label for="paket_menu" class="block text-sm font-medium mb-2">Paket Menu</label>
                        <select 
                            id="paket_menu" 
                            name="paket_menu" 
                            required
                            class="w-full bg-neutral-900 border border-neutral-600 rounded-lg px-4 py-3 text-white input-focus outline-none transition"
                        >
                            <option value="" disabled selected>Pilih paket menu</option>
                            <option value="Paket Premium Suite">Paket Premium Suite</option>
                            <option value="Paket Deluxe Room">Paket Deluxe Room</option>
                            <option value="Paket Executive Suite">Paket Executive Suite</option>
                            <option value="Paket Presidential Suite">Paket Presidential Suite</option>
                            <option value="Paket Honeymoon Special">Paket Honeymoon Special</option>
                            <option value="Paket Family Package">Paket Family Package</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full gold-gradient text-black font-semibold py-3 rounded-lg hover:opacity-90 transition transform hover:scale-105 duration-200"
                    >
                        Kirim Reservasi
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-neutral-400">
                    <p>Dengan melakukan reservasi, Anda menyetujui <a href="#" class="text-yellow-500 hover:underline">syarat dan ketentuan</a> kami</p>
                </div>
            </div>

            <!-- Right Side - Image -->
            <div class="hidden md:block">
                <div class="relative rounded-2xl overflow-hidden border-8 border-yellow-500">
                    <img 
                        src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&h=900&fit=crop" 
                        alt="Luxury Hotel" 
                        class="w-full h-[600px] object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <h3 class="luxury-title text-3xl font-bold mb-2">Pengalaman Mewah Menanti Anda</h3>
                        <p class="text-neutral-200">Nikmati kemewahan dan kenyamanan di setiap sudut resort kami dengan fasilitas premium dan pelayanan eksklusif.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('reservasiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                nama: document.getElementById('nama').value,
                no_hp: document.getElementById('no_hp').value,
                email: document.getElementById('email').value,
                paket_menu: document.getElementById('paket_menu').value
            };

            // Simulasi pengiriman data (untuk demo)
            console.log('Data Reservasi:', formData);
            
            // Tampilkan pesan sukses
            document.getElementById('successMessage').classList.remove('hidden');
            
            // Reset form
            this.reset();
            
            // Scroll ke pesan sukses
            document.getElementById('successMessage').scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Sembunyikan pesan setelah 5 detik
            setTimeout(() => {
                document.getElementById('successMessage').classList.add('hidden');
            }, 5000);
        });
    </script>
</body>
</html>