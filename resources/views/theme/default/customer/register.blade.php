<x-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/templatemo-hexashop.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/adidas_custom.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    </head>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f8f9fa;">
        <div class="card shadow p-4 border-0" style="min-width: 350px; max-width: 400px; width: 100%; background: #fff;">
            <h3 class="mb-4 text-center fw-bold text-dark">Register</h3>

            @if(session('errorMessage'))
                <div class="alert alert-danger">
                    {{ session('errorMessage') }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.store_register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-dark">Name</label>
                    <input 
                        type="text" 
                        class="form-control border-dark @error('name') is-invalid @enderror"  
                        id="name" 
                        name="name"  
                        value="{{ old('name') }}" 
                        required
                        autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-dark">Email address</label>
                    <input 
                        type="email" 
                        class="form-control border-dark @error('email') is-invalid @enderror" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required
                        name="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-dark">Password</label>
                    <input 
                        type="password" 
                        class="form-control border-dark @error('password') is-invalid @enderror"  
                        id="password" 
                        required
                        name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label text-dark">Confirm Password</label>
                    <input 
                        type="password" 
                        class="form-control border-dark @error('password_confirmation') is-invalid @enderror"   
                        id="password_confirmation"
                        required 
                        name="password_confirmation">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark w-100">Register</button>
            </form>

            <div class="mt-3 text-center">
                <small class="text-dark">
                    Sudah memiliki akun? 
                    <a href="{{ route('customer.login') }}" class="link-dark fw-semibold">Login</a>
                </small>
            </div>
        </div>
    </div>
</x-layout>
