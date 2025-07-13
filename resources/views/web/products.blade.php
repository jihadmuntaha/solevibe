<x-layout>
    <x-slot name="title"> Products</x-slot>

    <head>
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/templatemo-hexashop.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/lightbox.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/adidas_custom.css') }}"> {{-- CSS Custom Hitam Putih --}}
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    </head>

    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4 section-title-container">
            <h3 class="section-title">Product Kami</h3>
            <form action="{{ url()->current() }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-dark text-white">Cari</button> {{-- Tombol cari juga hitam putih --}}
            </form>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 col-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}" class="card-img-top" alt="{{ $product->name }}" style="object-fit: contain; height: 200px; padding: 10px;">

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

                @if ($loop->iteration == 12 && $products->count() > 12)
                    <div class="col-12 product-grid-banner">
                        <img src="{{ asset('theme/hexashop/assets/images/banner.jpg') }}" alt="" class="img-fluid">
                    </div>
                @endif

            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">Belum ada produk pada kategori ini.</div>
                </div>
            @endforelse

            <div class="d-flex justify-content-center w-100 mt-4">
                {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .btn-dark {
            background-color: #000;
            border: none;
        }
        .btn-dark:hover {
            background-color: #333;
        }
        .text-dark {
            color: #000 !important;
        }
    </style>
    @endpush

</x-layout>
