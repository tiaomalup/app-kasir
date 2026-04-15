<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'users'; // atau 'users' jika kamu pakai tabel users

    protected $fillable = [
        'name',
        'email',
        'profile_picture',
        'password',
    ];
}
