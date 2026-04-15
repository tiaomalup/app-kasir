<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Akun Kasir</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen px-6 py-10">

  <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-purple-700 mb-6">
      Tambah Akun Kasir
    </h1>

    <!-- ERROR VALIDATION -->
    @if ($errors->any())
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        <ul>
          @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- FORM -->
    <form action="{{ url('/admin/akun') }}" method="POST">
      @csrf

      <!-- USERNAME -->
      <div class="mb-4">
        <label class="block mb-1 font-semibold">Username</label>
        <input 
          type="text" 
          name="username" 
          value="{{ old('username') }}"
          required
          class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400"
        >
      </div>

      <!-- PASSWORD -->
      <div class="mb-4">
        <label class="block mb-1 font-semibold">Password</label>
        <input 
          type="password" 
          name="password" 
          required
          class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400"
        >
      </div>

      <!-- BUTTON -->
      <div class="flex justify-between">
        <a href="{{ url('/admin/akun') }}" class="text-gray-600 hover:underline">
          ← Kembali
        </a>

        <button 
          type="submit" 
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
        >
          Simpan
        </button>
      </div>

    </form>
  </div>

</body>
</html>