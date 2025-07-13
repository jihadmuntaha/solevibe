<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product; // Untuk mencari produk berdasarkan ID dari hub
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // Jangan lupa import Validator

class OrderWebhookController extends Controller
{
    public function handleIncomingOrder(Request $request)
    {
        // Validasi data yang masuk dari webhook
        $validator = Validator::make($request->all(), [
            'order_id_from_hub' => 'required|string|unique:orders,hub_order_id', // ID unik dari hub
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_address' => 'required|string',
            'total_amount' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id_from_hub' => 'required', // ID produk dari hub
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            // Tambahkan validasi lain sesuai format data dari hub
        ]);

        if ($validator->fails()) {
            Log::error('Incoming order webhook validation failed', ['errors' => $validator->errors()->toArray(), 'payload' => $request->all()]);
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try {
            // Buat atau temukan pelanggan (jika Anda melacak pelanggan dari hub)
            // Atau simpan detail pelanggan langsung di order

            // Simpan Order
            $order = Order::create([
                'hub_order_id' => $request->order_id_from_hub, // Kolom baru di tabel orders
                'user_id' => null, // Atau temukan user_id berdasarkan customer_email dari hub
                'total_amount' => $request->total_amount,
                'shipping_cost' => $request->shipping_cost,
                'status' => 'pesanan diterima', // Status awal
                'billing_fullname' => $request->customer_name,
                'billing_email' => $request->customer_email,
                'billing_address' => $request->customer_address,
                // Tambahkan kolom lain yang relevan dari hub
            ]);

            foreach ($request->items as $itemData) {
                $product = Product::where('id_from_hub', $itemData['product_id_from_hub'])->first(); // Asumsi ada ID produk dari hub

                if (!$product) {
                    // Jika produk tidak ditemukan di sistem Anda, log error atau abort
                    Log::warning("Product with hub ID {$itemData['product_id_from_hub']} not found for order {$order->id}");
                    // Anda bisa memilih untuk rollback atau membuat order detail tanpa product_id
                    continue; // Lewati item ini atau lempar exception
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price_at_purchase' => $itemData['price'],
                    // Tambahkan detail lain dari itemData jika ada
                ]);

                // Opsional: Kurangi stok produk (jika Anda mengelola stok di aplikasi ini)
                $product->stock -= $itemData['quantity'];
                $product->save();
            }

            DB::commit();
            return response()->json(['message' => 'Order received successfully', 'order_id' => $order->id], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing incoming order webhook: ' . $e->getMessage(), ['trace' => $e->getTraceAsString(), 'payload' => $request->all()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}