<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-orange-100 min-h-screen flex justify-center items-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-sm">
        <!-- Gambar Profil -->
        <div class="w-32 h-32 mx-auto rounded-full border-4 border-orange-400 overflow-hidden">
            <img src="<?php echo e($admin->profile_picture); ?>" alt="Profile Picture" class="object-cover w-full h-full">
        </div>

        <!-- Nama dan Email -->
        <h2 class="text-2xl font-bold text-blue-900 mt-4"><?php echo e($admin->name); ?></h2>
        <p class="text-gray-500"><?php echo e($admin->email); ?></p>

        <!-- Informasi tambahan -->
        <div class="mt-4">
            <p class="text-gray-700 font-semibold">Role: <span class="text-orange-600">Administrator</span></p>
            <p class="text-gray-700 font-semibold">Bergabung: <span class="text-orange-600"><?php echo e($admin->created_at->format('M Y')); ?></span></p>
        </div>

        <!-- Tombol Edit Profil -->
        <div class="mt-6 text-center">
            <a href="<?php echo e(route('profil.edit')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition">
                Edit Profil
            </a>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\apk_boba\resources\views/admin/profil.blade.php ENDPATH**/ ?>