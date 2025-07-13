<x-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/templatemo-hexashop.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/hexashop/assets/css/adidas_custom.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    </head>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f8f9fa;">
        <div class="card shadow p-4 border-0" style="min-width: 350px; max-width: 400px; width: 100%; background: #fff;">
            <h3 class="mb-4 text-center fw-bold text-dark">Login</h3>

            @if(session('errorMessage'))
                <div class="alert alert-danger">
                    {{ session('errorMessage') }}
                </div>
            @endif

            @if(session('successMessage'))
                <div class="alert alert-success">
                    {{ session('successMessage') }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-dark">Email address</label>
                    <input 
                        type="email" 
                        class="form-control border-dark @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                    >
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
                        name="password" 
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input border-dark" id="remember" name="remember">
                    <label class="form-check-label text-dark" for="remember">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-dark w-100">Login</button>
                <div class="mt-3 text-center">
                    <small class="text-dark">
                        Belum punya akun?
                        <a href="{{ route('customer.register') }}" class="link-dark fw-semibold">Daftar disini</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</x-layout>
