<x-layout>
    <x-slot name="title">Homepage</x-slot>

    <head>
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/templatemo-hexashop.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/lightbox.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/adidas_custom.css') }}"> {{-- CSS custom monokrom --}}
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    </head>

    <div class="hero-banner">
        <img src="{{ asset('theme/hexashop/assets/images/adidas_image_converted.jpg') }}" alt="Adidas New Collection" class="img-fluid w-100">
        <div class="hero-content">
            <h1>Koleksi Terbaru Adidas</h1>
            <p>Jelajahi sepatu-sepatu inovatif untuk gaya hidup aktif Anda.</p>
            <a href="{{ url('/products') }}" class="btn btn-dark text-white hero-button">Belanja Sekarang</a>
        </div>
    </div>

 <div class="container-fluid px-3 py-3 position-relative">
    <!-- Header: Judul dan Tombol -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="section-title mb-0">Kategori Produk</h3>
        <a href="{{ url('/categories') }}" class="btn btn-dark btn-sm text-white">Lihat Semua Kategori</a>
    </div>

    <!-- Tombol Scroll (Mobile Only) -->
    <button class="scroll-btn left" onclick="scrollCategory(-1)">
        &#8249;
    </button>
    <button class="scroll-btn right" onclick="scrollCategory(1)">
        &#8250;
    </button>

    <!-- Kontainer Kategori Scroll -->
    <div class="category-scroll-container" id="categoryScroll">
        @foreach($categories as $category)
            <a href="{{ url('/category/'.$category->slug) }}" class="category-icon">
                <div class="icon-wrapper">
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}">
                    @else
                        <img src="https://via.placeholder.com/64" alt="No Image">
                    @endif
                </div>
                <p class="category-name mt-2">{{ $category->name }}</p>
            </a>
        @endforeach
    </div>
</div>
<script>
function scrollCategory(direction) {
    const container = document.getElementById("categoryScroll");
    const scrollAmount = 150;
    container.scrollBy({
        left: direction * scrollAmount,
        behavior: "smooth"
    });
}
</script>



    </div>

    <div class="container-lg py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="section-title">Product Kami</h3>
        <a href="{{ url('/products') }}" class="btn btn-dark btn-sm text-white">Lihat Semua Product</a>
    </div>
    <div class="row">
        @forelse($products as $product)
            <div class="col-4 col-md-3 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}" class="card-img-top" alt="{{ $product->name }}">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-truncate">{{ $product->description }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-dark btn-sm text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-info">Belum ada produk pada kategori ini.</div>
            </div>
        @endforelse

        <div class="d-flex justify-content-center w-100 mt-4">
            {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
        </div>
    </div>
</div>

</x-layout>