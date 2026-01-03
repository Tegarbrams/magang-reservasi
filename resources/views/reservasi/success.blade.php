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
            background: linear-gradient(135deg, #FFF9E6 0%, #FFFFFF 50%, #FFF9E6 100%);
        }

        .luxury-title {
            font-family: 'Playfair Display', serif;
        }

        .gold-gradient {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
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
<body class="min-h-screen p-4">
    
    @include('template.header')
    
    <div class="flex items-center justify-center p-4 pt-24 sm:pt-28">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8 sm:py-12 md:py-16 max-w-2xl w-full">
        
        <!-- Success Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-6 sm:p-8 md:p-12 border-2 sm:border-4 border-yellow-400 text-center success-animation shadow-2xl">
            
            <!-- Checkmark Icon -->
            <div class="mb-6 sm:mb-8 flex justify-center">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full gold-gradient flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path class="checkmark" d="M5 13l4 4L19 7" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="luxury-title text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 text-gray-800 px-2">Reservasi Berhasil!</h1>
            <p class="text-gray-600 text-base sm:text-lg mb-6 sm:mb-8 px-2">
                Terima kasih telah melakukan reservasi di <span class="text-yellow-600 font-semibold">LUXURY Hotel</span>
            </p>

            <!-- Info Box -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-400 rounded-lg p-4 sm:p-6 mb-6 sm:mb-8 text-left shadow-md">
                <h3 class="font-semibold text-yellow-700 mb-3 flex items-center gap-2 text-sm sm:text-base">
                    <span class="text-xl sm:text-2xl">📋</span>
                    <span>Informasi Penting:</span>
                </h3>
                <ul class="space-y-2 text-gray-700 text-xs sm:text-sm">
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 font-bold flex-shrink-0">✓</span>
                        <span>Reservasi Anda sedang dalam proses verifikasi</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 font-bold flex-shrink-0">✓</span>
                        <span>Kami akan menghubungi Anda melalui email/WhatsApp dalam 1x24 jam</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 font-bold flex-shrink-0">✓</span>
                        <span>Pastikan nomor handphone dan email Anda aktif</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 font-bold flex-shrink-0">✓</span>
                        <span>Simpan bukti pembayaran Anda</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="gold-gradient text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg transform hover:scale-105 transition-all text-sm sm:text-base w-full sm:w-auto">
                    🏠 Kembali ke Beranda
                </a>
                <a href="{{ route('reservasi.index') }}" 
                   class="bg-white border-2 border-yellow-400 text-yellow-700 px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-yellow-50 transition shadow-md hover:shadow-lg transform hover:scale-105 transition-all text-sm sm:text-base w-full sm:w-auto">
                    📝 Reservasi Lagi
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t-2 border-yellow-200">
                <p class="text-gray-500 text-xs sm:text-sm mb-3 font-medium">Butuh bantuan?</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-6 text-xs sm:text-sm">
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-green-600 hover:text-green-700 font-medium hover:underline">
                        📱 WhatsApp
                    </a>
                    <a href="mailto:info@luxuryhotel.com" class="text-blue-600 hover:text-blue-700 font-medium hover:underline">
                        📧 Email
                    </a>
                    <a href="tel:+6281234567890" class="text-yellow-600 hover:text-yellow-700 font-medium hover:underline">
                        📞 Telepon
                    </a>
                </div>
            </div>
        </div>

    </div>
</body>
</html>