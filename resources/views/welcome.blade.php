<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusCare | Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-linear-to-b from-blue-100 to-blue-300 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-2xl p-8 max-w-lg w-full text-center">
        <h1 class="text-3xl font-bold text-blue-700 mb-4">Selamat Datang di <span class="text-blue-500">CampusCare</span></h1>
        <p class="text-gray-600 mb-8">Pilih bagaimana kamu ingin masuk ke sistem:</p>

        <div class="space-y-4">
            <a href="{{ url('login/google') }}"class="block w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-lg shadow transition duration-200">Login sebagai <span class="font-bold">User</span> (Akun Google UNEJ)
            </a>

            <a href="{{ url('/login/mitra')}}"class="block w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg shadow transition duration-200">Login sebagai <span class="font-bold">Mitra</span>
            </a>


            <a href="{{ url('/register/mitra') }}"class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg shadow transition duration-200">Daftar sebagai <span class="font-bold">Mitra Baru</span></a>
        </div>

        <div class="mt-10 text-sm text-gray-500">
            <p>© {{ date('Y') }} CampusCare — Akses Kesehatan Mahasiswa Lebih Mudah.</p>
        </div>
    </div>

</body>
</html>
