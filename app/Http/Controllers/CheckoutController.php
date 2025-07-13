<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Binafy\LaravelCart\Models\Cart;
use Binafy\LaravelCart\Models\CartItem; // Pastikan ini di-import jika Anda akan menghapus item keranjang
use App\Models\Customer; // Asumsi Anda punya model Customer untuk user yang login
use App\Models\Order; // Impor model Order Anda
use App\Models\OrderDetail; // Impor model OrderDetail Anda
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class CheckoutController extends Controller
{
    private $cart;

    public function __construct()
    {
        if (auth()->guard('customer')->check()) {
            $this->cart = Cart::query()->firstOrCreate(
                [
                    'user_id' => auth()->guard('customer')->user()->id
                ]
            );
        } else {
            // Jika pengguna belum login, redirect atau tangani sesuai kebutuhan
            $this->cart = null; 
            // Opsional: Redirect ke login jika constructor dipanggil untuk route yang memerlukan auth
            // if (!request()->routeIs('customer.login', 'customer.register')) {
            //     return redirect()->route('customer.login')->send();
            // }
        }
    }

    public function index()
    {
        // Pastikan keranjang tidak ditemukan atau kosong, mungkin redirect kembali
        if (!$this->cart || $this->cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong. Tidak dapat melanjutkan ke pembayaran.');
        }

        // Buat variabel lokal $cart dari properti $this->cart
        $cart = $this->cart; 

        // Logika pembersihan item keranjang yang tidak valid (disarankan)
        $itemsToRemove = [];
        foreach ($cart->items as $item) {
            if (!$item->itemable) {
                $itemsToRemove[] = $item->id;
            }
        }
        if (!empty($itemsToRemove)) {
            CartItem::destroy($itemsToRemove);
            $cart->load('items'); // Muat ulang relasi items setelah penghapusan
        }

        // Jika keranjang kosong setelah pembersihan, redirect
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong setelah pembersihan item tidak valid. Tidak dapat melanjutkan ke pembayaran.');
        }

        // Dapatkan total harga dari keranjang
        $subtotal = $cart->calculatedPriceByQuantity();
        $shippingCost = 5000; 
        $freeShippingThreshold = 50000;
        
        if ($subtotal >= $freeShippingThreshold) {
            $shippingCost = 0;
        }

        $total = $subtotal + $shippingCost;
        $title = "Checkout"; // Definisi $title di sini

        // Mengirimkan semua variabel yang diperlukan ke view checkout
        return view('checkout', compact('cart', 'subtotal', 'shippingCost', 'total', 'freeShippingThreshold', 'title'));
    }

    /**
     * Handle the form submission for checkout.
     * Ini adalah metode 'store' yang hilang.
     */
    public function store(Request $request)
    {
        // Pastikan keranjang terinisialisasi dan tidak kosong
        if (!$this->cart || $this->cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong. Tidak dapat memproses pesanan.');
        }

        // --- 1. Validasi Data Form ---
        $validator = \Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            // Validasi pembayaran jika Anda memprosesnya di sini
            'card_name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:20', // Sesuaikan validasi dengan kebutuhan Anda
            'card_exp' => 'nullable|string|max:5',
            'card_cvv' => 'nullable|string|max:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validasi gagal. Silakan periksa kembali data Anda.');
        }

        // --- 2. Hitung Ulang Total Harga (Penting untuk keamanan) ---
        $subtotal = $this->cart->calculatedPriceByQuantity();
        $shippingCost = 5000; // Pastikan ini konsisten dengan index()
        $freeShippingThreshold = 50000; 
        if ($subtotal >= $freeShippingThreshold) {
            $shippingCost = 0;
        }
        $total = $subtotal + $shippingCost;

        // --- 3. Proses Transaksi Database ---
        // Menggunakan transaksi untuk memastikan semua operasi sukses atau tidak sama sekali
        try {
            DB::beginTransaction();

            // Buat entri Order
            $order = Order::create([
                'user_id' => auth()->guard('customer')->user()->id,
                'total_amount' => $total,
                'shipping_cost' => $shippingCost,
                'status' => 'pending', // Atau status awal lainnya
                'billing_fullname' => $request->fullname,
                'billing_email' => $request->email,
                'billing_address' => $request->address,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_zip' => $request->zip,
                // Tambahkan detail pembayaran jika Anda menyimpannya
                // 'card_name' => $request->card_name,
                // 'card_number' => $request->card_number,
                // 'card_exp' => $request->card_exp,
                // 'card_cvv' => $request->card_cvv,
            ]);

            // Buat entri OrderDetail untuk setiap item di keranjang
            foreach ($this->cart->items as $item) {
                if ($item->itemable) { // Pastikan produk masih ada
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->itemable_id,
                        'quantity' => $item->quantity,
                        'price_at_purchase' => $item->itemable->price, // Harga saat dibeli
                        // Tambahkan kolom lain seperti nama produk, SKU, dll. jika dibutuhkan
                    ]);

                    // Opsional: Kurangi stok produk
                    $product = $item->itemable;
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            // --- 4. Kosongkan Keranjang ---
            $this->cart->clear(); // Menggunakan metode clear() dari library Laravel-Cart

            DB::commit();

            return redirect()->route('home')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            \Log::error('Checkout failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.')->withInput();
        }
    }
}