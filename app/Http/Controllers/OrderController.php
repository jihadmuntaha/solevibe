<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Pastikan ini di-import
use App\Models\OrderDetail; // Pastikan ini di-import
use App\Models\Product; // Pastikan ini di-import jika OrderDetail punya relasi ke Product
use App\Jobs\SendOrderStatusUpdateToHub; // Pastikan ini di-import jika Anda sudah punya Job ini
use Illuminate\Support\Facades\DB; // Pastikan ini di-import jika digunakan untuk transaksi

class OrderController extends Controller
{
    public function index()
    {
        // Pastikan relasi 'details' dan 'details.product' dimuat
        $orders = Order::with('details.product')->latest()->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }

    // ... (metode show, updateStatus, dll.)
}