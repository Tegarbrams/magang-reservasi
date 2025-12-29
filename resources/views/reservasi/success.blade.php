<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Berhasil - Luxury Hotel</title>
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

        .success-animation {
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .checkmark {
            animation: drawCheck 0.5s ease-out 0.3s forwards;
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
        }

        @keyframes drawCheck {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>
</head>
<body class="bg-neutral-900 text-white min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-8 py-16 max-w-2xl">
        
        <!-- Success Card -->
        <div class="bg-neutral-800 rounded-2xl p-12 border border-neutral-700 text-center success-animation">
            
            <!-- Checkmark Icon -->
            <div class="mb-8 flex justify-center">
                <div class="w-24 h-24 rounded-full gold-gradient flex items-center justify-center">
                    <svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path class="checkmark" d="M5 13l4 4L19 7" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="luxury-title text-4xl font-bold mb-4">Reservasi Berhasil!</h1>
            <p class="text-neutral-300 text-lg mb-8">
                Terima kasih telah melakukan reservasi di <span class="text-yellow-500 font-semibold">LUXURY Hotel</span>
            </p>

            <!-- Info Box -->
            <div class="bg-neutral-900 border border-yellow-500/30 rounded-lg p-6 mb-8 text-left">
                <h3 class="font-semibold text-yellow-500 mb-3">📋 Informasi Penting:</h3>
                <ul class="space-y-2 text-neutral-300 text-sm">
                    <li>✓ Reservasi Anda sedang dalam proses verifikasi</li>
                    <li>✓ Kami akan menghubungi Anda melalui email/WhatsApp dalam 1x24 jam</li>
                    <li>✓ Pastikan nomor handphone dan email Anda aktif</li>
                    <li>✓ Simpan bukti pembayaran Anda</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="gold-gradient text-black px-8 py-3 rounded-lg font-semibold hover:opacity-90 transition">
                    🏠 Kembali ke Beranda
                </a>
                <a href="{{ route('reservasi.index') }}" 
                   class="border border-neutral-600 px-8 py-3 rounded-lg font-semibold hover:border-yellow-500 transition">
                    📝 Reservasi Lagi
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-8 pt-8 border-t border-neutral-700">
                <p class="text-neutral-400 text-sm mb-2">Butuh bantuan?</p>
                <div class="flex justify-center gap-6 text-sm">
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-green-400 hover:text-green-300">
                        📱 WhatsApp
                    </a>
                    <a href="mailto:info@luxuryhotel.com" class="text-blue-400 hover:text-blue-300">
                        📧 Email
                    </a>
                    <a href="tel:+6281234567890" class="text-yellow-400 hover:text-yellow-300">
                        📞 Telepon
                    </a>
                </div>
            </div>
        </div>

    </div>
</body>
</html>