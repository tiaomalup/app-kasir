<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirTransaction extends Model
{
    use HasFactory;

    protected $table = 'kasir_transactions'; // pastikan nama tabel sesuai

    protected $fillable = [
        'kasir_id',
        'order_id',
    ];

    /**
     * Relasi ke order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke kasir.
     */
    public function kasir()
    {
        return $this->belongsTo(Kasir::class);
    }
}
