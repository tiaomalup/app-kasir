<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'total',
        'service_type',
        'status',
        'payment_method',
        'uang_masuk',
        'kembalian',
        'paid_at',
        'midtrans_order_id',
    ];

    // ✅ TAMBAHKAN INI
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}