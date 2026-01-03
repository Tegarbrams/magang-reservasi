<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Luxury Hotel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap');

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

    .input-gold:focus {
        outline: none;
        border-color: #FFD700;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
    }

    .card-entrance {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
  </style>
</head>
<body class="min-h-screen p-4">

    @include('template.header')

    <div class="flex items-center justify-center w-full p-4 pt-24 sm:pt-28">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 sm:p-8 border-2 border-yellow-400 card-entrance">
        
        <!-- Logo/Icon -->
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 sm:w-20 sm:h-20 gold-gradient rounded-full flex items-center justify-center shadow-lg">
                <span class="text-3xl sm:text-4xl">👑</span>
            </div>
        </div>

        <h2 class="luxury-title text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-2">Login</h2>
        <p class="text-center text-gray-600 text-sm mb-6">Selamat datang kembali di Luxury Hotel</p>

        @if(session('error'))
            <div class="bg-red-50 border-2 border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <span class="font-semibold">❌ Error:</span> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border-2 border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <span class="font-semibold">✓ Berhasil:</span> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Email Input -->
            <div>
                <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">📧 Email</label>
                <input type="email" name="email" required 
                    class="input-gold w-full px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg transition text-sm sm:text-base"
                    placeholder="contoh@email.com">
            </div>

            <!-- Password Input -->
            <div>
                <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">🔒 Password</label>
                <input type="password" name="password" required 
                    class="input-gold w-full px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg transition text-sm sm:text-base"
                    placeholder="Masukkan password">
            </div>
            
            <!-- Lupa Password Link -->
            <div class="text-right">
                <a href="{{ route('password.request') }}" class="text-xs sm:text-sm text-yellow-600 hover:text-yellow-700 font-medium hover:underline">
                    Lupa Password?
                </a>
            </div>

            <!-- Login Button -->
            <button type="submit" 
                class="w-full gold-gradient text-white py-2.5 sm:py-3 rounded-lg font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg transform hover:scale-105 transition-all text-sm sm:text-base">
                🔐 Masuk
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-1 border-t-2 border-gray-200"></div>
            <span class="px-4 text-gray-500 text-xs sm:text-sm">atau</span>
            <div class="flex-1 border-t-2 border-gray-200"></div>
        </div>

        <!-- Register Link -->
        <p class="text-center text-xs sm:text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold hover:underline">
                Daftar Sekarang
            </a>
        </p>

        <!-- Footer Text -->
        <p class="text-center text-xs text-gray-400 mt-6">
            🏨 Luxury Hotel - Pengalaman Menginap Terbaik
        </p>
            </div>
    </div>

</body>
</html>