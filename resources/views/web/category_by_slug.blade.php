@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

<x-layout>
    <x-slot name="title">{{ $category->name }}</x-slot>

    <head>
        {{-- Link CSS wajib --}}
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/templatemo-hexashop.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/lightbox.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/adidas_custom.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    </head>

    <div class="container py-4">
        <!-- Header Kategori -->
        <div class="row mb-4">
            <div class="col">
                <h3 class="mb-2" style="font-size: 1.7rem;">{{ $category->name }}</h3>
                <p class="text-muted">{{ $category->description }}</p>
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img
                            src="{{ $product->image_url
                                ? (Str::startsWith($product->image_url, ['http', 'https'])
                                    ? $product->image_url
                                    : Storage::url($product->image_url))
                                : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                            class="card-img-top"
                            alt="{{ $product->name }}"
                            style="height: 200px; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-truncate">{{ $product->description }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="btn btn-dark btn-sm text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info">Belum ada produk pada kategori ini.</div>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="d-flex justify-content-center w-100 mt-4">
                {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
            </div>
        </div>
    </div>
</x-layout>
