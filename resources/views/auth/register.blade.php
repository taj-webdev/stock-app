<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Stock App</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-green-100 via-white to-green-200 flex items-center justify-center min-h-screen">

    <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 w-full max-w-md transition-all duration-500 hover:shadow-green-300">
        <div class="text-center mb-6">
            <i data-lucide="user-plus" class="w-10 h-10 text-green-600 mx-auto mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
            <p class="text-sm text-gray-500">Isi form di bawah untuk membuat akun</p>
        </div>

        @if($errors->any())
            <div class="p-3 bg-red-100 border border-red-300 text-red-700 text-sm rounded-md mb-4">{{ $errors->first() }}</div>
        @endif

        <form id="registerForm" action="{{ route('register.process') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-green-500">
                    <i data-lucide="user" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="text" name="name" class="w-full outline-none bg-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-green-500">
                    <i data-lucide="at-sign" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="text" name="username" class="w-full outline-none bg-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-green-500">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="password" name="password" class="w-full outline-none bg-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-green-500">
                    <i data-lucide="check-circle" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="password" name="password_confirmation" class="w-full outline-none bg-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <div class="flex items-center border rounded-lg px-3 py-2 mt-1 focus-within:ring-2 focus-within:ring-green-500">
                    <i data-lucide="shield" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <select name="role" class="w-full outline-none bg-transparent" required>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
            </div>

            <button id="registerBtn" type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg flex justify-center items-center gap-2 hover:bg-green-700 transition-all duration-300">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>Register</span>
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-5">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-green-600 hover:underline">Login di sini</a>
        </p>
    </div>

    <script>
        lucide.createIcons();
        const regForm = document.getElementById('registerForm');
        const regBtn = document.getElementById('registerBtn');

        regForm.addEventListener('submit', function () {
            regBtn.disabled = true;
            regBtn.innerHTML = `<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> <span>Mendaftar...</span>`;
            lucide.createIcons();
        });
    </script>
</body>
</html>
