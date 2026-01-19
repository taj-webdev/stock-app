<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Stock App</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 flex items-center justify-center min-h-screen">

    <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 w-full max-w-sm transition-all duration-500 hover:shadow-blue-300">
        <div class="text-center mb-6">
            <i data-lucide="log-in" class="w-10 h-10 text-blue-600 mx-auto mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-800">Login ke <span class="text-blue-600">Stock App</span></h2>
            <p class="text-sm text-gray-500">Masukkan kredensial untuk melanjutkan</p>
        </div>

        @if(session('success'))
            <div class="p-3 bg-green-100 border border-green-300 text-green-700 text-sm rounded-md mb-4">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="p-3 bg-red-100 border border-red-300 text-red-700 text-sm rounded-md mb-4">{{ $errors->first() }}</div>
        @endif

        <form id="loginForm" action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-blue-500">
                    <i data-lucide="user" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="text" name="username" class="w-full outline-none bg-transparent text-gray-800" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-blue-500">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="password" name="password" class="w-full outline-none bg-transparent text-gray-800" placeholder="Masukkan password" required>
                </div>
            </div>

            <button id="loginBtn" type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg flex justify-center items-center gap-2 hover:bg-blue-700 transition-all duration-300">
                <i data-lucide="log-in" class="w-5 h-5"></i>
                <span>Login</span>
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-5">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
    </div>

    {{-- Loading Screen saat sukses login --}}
    <div id="loadingScreen" class="fixed inset-0 bg-white/90 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="flex flex-col items-center">
            <i data-lucide="loader" class="w-10 h-10 text-blue-600 animate-spin"></i>
            <p class="mt-2 text-gray-700 font-medium">Memuat Dashboard...</p>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const loadingScreen = document.getElementById('loadingScreen');

        loginForm.addEventListener('submit', function () {
            loginBtn.disabled = true;
            loginBtn.innerHTML = `<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> <span>Memproses...</span>`;
            lucide.createIcons();
        });

        // Simulasi loading dashboard setelah login sukses (delay animasi)
        @if(session('login_success'))
            loadingScreen.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = "{{ route('dashboard') }}";
            }, 2000);
        @endif
    </script>
</body>
</html>
