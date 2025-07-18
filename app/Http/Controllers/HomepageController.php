<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categories;
use App\Models\Product;

use App\Models\Theme;
use \Binafy\LaravelCart\Models\Cart;
use \Binafy\LaravelCart\Models\CartItem; // Pastikan ini di-import

class HomepageController extends Controller
{
    private $themeFolder;

    public function __construct()
    {
        $theme = Theme::where('status', 'active')->first();
        if ($theme) {
            $this->themeFolder = $theme->folder;
        } else {
            $this->themeFolder = 'web';
        }
    }

    public function index()
    {
        $categories = Categories::latest()->take(20  )->get();
        $products = Product::paginate(20);

        return view($this->themeFolder . '.homepage', [
            'categories' => $categories,
            'products' => $products,
            'title' => 'Homepage'
        ]);
    }

    public function products(Request $request)
    {
        $title = "Products";

        $query = Product::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        return view($this->themeFolder . '.products', [
            'title' => $title,
            'products' => $products,
        ]);
    }

    public function product($slug)
    {
        $product = Product::whereSlug($slug)->first();

        if (!$product) {
            return abort(404);
        }

        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view($this->themeFolder . '.product', [
            'slug' => $slug,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function categories()
    {
        $categories = Categories::latest()->paginate(20);

        return view($this->themeFolder . '.categories', [
            'title' => 'Categories',
            'categories' => $categories,
        ]);
    }

    public function category($slug)
    {
        $category = Categories::whereSlug($slug)->first();

        if ($category) {
            $products = Product::where('product_category_id', $category->id)->paginate(20);

            return view($this->themeFolder . '.category_by_slug', [
                'slug' => $slug,
                'category' => $category,
                'products' => $products,
            ]);
        } else {
            return abort(404);
        }
    }

    public function cart()
    {
        $cart = null; // Inisialisasi default
        if (auth()->guard('customer')->check()) {
            $cart = Cart::query()
                ->with(['items', 'items.itemable']) // Eager load itemable
                ->where('user_id', auth()->guard('customer')->user()->id)
                ->first();

            // Logika pembersihan item keranjang yang tidak valid
            $itemsToRemove = [];
            if ($cart) {
                foreach ($cart->items as $item) {
                    if (!$item->itemable) {
                        $itemsToRemove[] = $item->id;
                    }
                }
            }

            if (!empty($itemsToRemove)) {
                CartItem::destroy($itemsToRemove);
                $cart->load('items'); // Muat ulang relasi items setelah penghapusan
            }
        }

        return view($this->themeFolder . '.cart', [
            'title' => 'Cart',
            'cart' => $cart,
        ]);
    }

    public function checkout()
    {
        $title = "Checkout"; // Variabel $title didefinisikan di sini

        $cart = null; // Inisialisasi default
        $subtotal = 0;
        $shippingCost = 0;
        $total = 0;
        $freeShippingThreshold = 50000; // Definisi ambang batas gratis ongkir

        // Pastikan user login sebelum bisa mengakses keranjang dan checkout
        if (auth()->guard('customer')->check()) {
            $cart = Cart::query()
                ->with(['items', 'items.itemable']) // Eager load itemable
                ->where('user_id', auth()->guard('customer')->user()->id)
                ->first();

            // --- LOGIKA PEMBERSIHAN ITEM KERANJANG YANG TIDAK VALID ---
            $itemsToRemove = [];
            if ($cart) { // Pastikan $cart tidak null sebelum iterasi item
                foreach ($cart->items as $item) {
                    if (!$item->itemable) { // Periksa apakah produk terkait ada
                        $itemsToRemove[] = $item->id;
                    }
                }
            }

            if (!empty($itemsToRemove)) {
                CartItem::destroy($itemsToRemove);
                $cart->load('items'); // Muat ulang relasi items setelah penghapusan
            }
            // --- AKHIR LOGIKA PEMBERSIHAN ---

            // Jika keranjang kosong setelah pembersihan, mungkin redirect atau tampilkan pesan
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong. Tidak dapat melanjutkan ke pembayaran.');
            }

            // Hitung total jika keranjang tidak kosong
            $subtotal = $cart->calculatedPriceByQuantity();
            $shippingCost = 5000; // Contoh biaya ongkir

            if ($subtotal >= $freeShippingThreshold) {
                $shippingCost = 0; // Gratis ongkir
            }
            $total = $subtotal + $shippingCost;

        } else {
            // Jika pengguna tidak login, redirect ke halaman login atau keranjang
            return redirect()->route('customer.login')->with('error', 'Silakan login untuk melanjutkan ke pembayaran.');
        }

        // Mengirimkan semua variabel yang diperlukan ke view checkout
        return view($this->themeFolder . '.checkout', compact('cart', 'subtotal', 'shippingCost', 'total', 'freeShippingThreshold', 'title'));
    }
}