<div>
    <nav class="navbar navbar-expand-lg p-3" style="background: linear-gradient(90deg, #000000ff 0%, #000000ff 100%);">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center" href="/">
                <img src="{{ asset('theme/hexashop/assets/images/logo1-removebg-preview.png') }}" alt="SoleVibe Logo" style="height: 40px; margin-right: 20px;">
                SoleVibe
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/products">Produk</a>
                    </li>
                </ul>

                <x-cart-icon></x-cart-icon>
                
@if(auth()->guard('customer')->check())
    <div class="dropdown">
        <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::guard('customer')->user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            {{-- PERUBAHAN DI SINI --}}
            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
            {{-- AKHIR PERUBAHAN --}}
            <li>
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </div>
@else
                    <a class="btn btn-outline-light me-2" href="{{ route('customer.login') }}">Login</a>
                    <a class="btn btn-light text-primary" href="{{ route('customer.register') }}">Register</a>
                @endif
            </div>
        </div>
    </nav>
</div>