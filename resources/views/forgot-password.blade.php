<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Lupa Password</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p class="text-gray-600 text-center mb-6">
            Masukkan email Anda untuk menerima link reset password
        </p>

        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
            </div>
            <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Kirim Link Reset
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Kembali ke Login</a>
        </p>
    </div>

</body>
</html>