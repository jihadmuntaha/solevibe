<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_cost',
        'status',
        'billing_fullname',
        'billing_email',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'hub_order_id', // Pastikan kolom ini ada di migrasi orders table
        'tracking_number', // Jika ada, pastikan juga di migrasi
    ];

    // Relasi ke Customer (jika ada)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id'); // Sesuaikan 'user_id' jika nama kolom berbeda
    }

    // --- RELASI KE ORDER DETAILS HARUS BERNAMA 'details()' ---
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    // --- AKHIR PERBAIKAN ---
}