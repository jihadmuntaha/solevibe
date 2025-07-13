<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Binafy\LaravelCart\Models\Cart;
use \Binafy\LaravelCart\Models\CartItem;
use App\Models\Product; // Pastikan ini di-import jika belum

class CartController extends Controller
{
    private $cart;

    public function __construct()
    {
        // Pastikan pengguna terautentikasi sebelum mencoba mendapatkan keranjang
        // Jika tidak, ini bisa menyebabkan error jika pengguna belum login
        if (auth()->guard('customer')->check()) {
            $this->cart = Cart::query()->firstOrCreate(
                [
                    'user_id' => auth()->guard('customer')->user()->id
                ]
            );
        } else {
            // Tangani kasus di mana pengguna belum login (misalnya redirect atau buat keranjang anonim)
            // Untuk demo ini, kita bisa menginisialisasi $this->cart sebagai null atau redirect
            $this->cart = null; // Atau throw new \Exception('User not authenticated');
        }
    }

    public function index()
    {
        // Jika keranjang tidak ada (misalnya user belum login), langsung tampilkan view kosong
        if (!$this->cart) {
            return view('web.cart', ['cart' => null]);
        }

        // --- PERBAIKAN UTAMA DI SINI ---
        // Bersihkan item keranjang yang produknya sudah tidak ada (itemable is null)
        $itemsToRemove = [];
        foreach ($this->cart->items as $item) {
            // Memuat relasi itemable secara eager untuk menghindari N+1 query dan memastikan relasi terisi
            // Jika itemable null, tandai untuk dihapus
            if (!$item->itemable) {
                $itemsToRemove[] = $item->id;
            }
        }

        // Hapus item-item yang tidak valid dari database
        if (!empty($itemsToRemove)) {
            CartItem::destroy($itemsToRemove);
            // Muat ulang relasi items setelah penghapusan
            $this->cart->load('items'); 
        }
        // --- AKHIR PERBAIKAN UTAMA ---

        return view('web.cart', ['cart' => $this->cart]);
    }

    public function add(Request $request)
    {
        // Pastikan keranjang sudah terinisialisasi
        if (!$this->cart) {
            return redirect()->back()->with('error', 'Anda harus login untuk menambahkan item ke keranjang.');
        }

        // Validate the request
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Invalid input data.')
                ->withErrors($validator)
                ->withInput();
        }

        // Find the product
        $product = Product::findOrFail($request->product_id);
        
        // Check if the product is available
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ini.');
        }

        // Cek apakah produk sudah ada di keranjang, jika ada, update kuantitas
        $existingCartItem = $this->cart->items()->where('itemable_id', $product->id)
                                        ->where('itemable_type', Product::class)
                                        ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk menambah kuantitas produk ini.');
            }
            $existingCartItem->quantity = $newQuantity;
            $existingCartItem->save();
        } else {
            // Jika belum ada, tambahkan sebagai item baru
            $cartItem = new CartItem([
                'itemable_id' => $product->id,
                'itemable_type' => Product::class,
                'quantity' => $request->quantity,
            ]);
            $this->cart->items()->save($cartItem);
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        // Pastikan keranjang sudah terinisialisasi
        if (!$this->cart) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
        }

        // Menggunakan $id sebagai ID CartItem, bukan Product ID
        $cartItem = CartItem::where('cart_id', $this->cart->id)->findOrFail($id);

        // Hapus item keranjang
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function update($id, Request $request)
    {
        // Pastikan keranjang sudah terinisialisasi
        if (!$this->cart) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
        }

        // Menggunakan $id sebagai ID CartItem, bukan Product ID
        $cartItem = CartItem::where('cart_id', $this->cart->id)->findOrFail($id);
        $product = $cartItem->itemable; // Dapatkan produk terkait

        if (!$product) {
            // Jika produk tidak ditemukan, hapus item keranjang yang tidak valid ini
            $cartItem->delete();
            return redirect()->route('cart.index')->with('error', 'Produk terkait item ini tidak ditemukan dan telah dihapus dari keranjang.');
        }

        $newQuantity = $cartItem->quantity;

        if ($request->action == 'decrease') {
            $newQuantity = max(1, $cartItem->quantity - 1); // Pastikan kuantitas tidak kurang dari 1
        } else if ($request->action == 'increase') {
            $newQuantity = $cartItem->quantity + 1;
        }

        // Cek stok sebelum update
        if ($product->stock < $newQuantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk kuantitas yang diminta.');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();
        
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }
}