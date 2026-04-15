<?php

return [

    'defaults' => [
        'guard' => 'web', // ✅ pakai web untuk admin
        'passwords' => 'admins',
    ],

    'guards' => [
        // ✅ ADMIN (pakai web)
        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // ✅ KASIR
        'kasir' => [
            'driver' => 'session',
            'provider' => 'kasirs',
        ],
    ],

    'providers' => [
        // ❌ HAPUS users

        // ✅ ADMIN
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // ✅ KASIR
        'kasirs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Kasir::class,
        ],
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'kasirs' => [
            'provider' => 'kasirs',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];