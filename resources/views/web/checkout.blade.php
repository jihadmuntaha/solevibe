<x-layout>
    <x-slot name="title">Checkout</x-slot>
    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush


    <div class="container my-5">
        <div class="row">
            <!-- Form Checkout -->
            <div class="col-md-7">
                <h4 class="mb-4">Detail Penagihan</h4>
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <!-- Informasi Penagihan -->
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            value="{{ old('fullname', auth()->guard('customer')->user()->name ?? '') }}" required>
                        @error('fullname') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', auth()->guard('customer')->user()->email ?? '') }}" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                            @error('state') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}" required>
                            @error('zip') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <hr class="my-4">
                    <h5 class="mb-3">Metode Pembayaran</h5>

                    @php $selectedMethod = old('payment_method', 'bank_transfer'); @endphp

                    <div class="mb-3">
                        @foreach(['bank_transfer' => 'Transfer Bank', 'cod' => 'Bayar di Tempat (COD)', 'ewallet' => 'E-Wallet', 'credit_card' => 'Kartu Kredit'] as $value => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="{{ $value }}" value="{{ $value }}" {{ $selectedMethod == $value ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                            </div>
                        @endforeach
                        @error('payment_method') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <!-- Field Kartu Kredit -->
                    <div id="creditCardFields" style="display: {{ $selectedMethod == 'credit_card' ? 'block' : 'none' }};">
                        <div class="mb-3">
                            <label for="cardName" class="form-label">Nama di Kartu</label>
                            <input type="text" class="form-control" id="cardName" name="card_name" value="{{ old('card_name') }}" placeholder="Nama sesuai kartu">
                            @error('card_name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Nomor Kartu Kredit</label>
                            <input type="text" class="form-control" id="cardNumber" name="card_number" value="{{ old('card_number') }}" placeholder="Nomor kartu">
                            @error('card_number') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cardExp" class="form-label">Masa Berlaku</label>
                                <input type="text" class="form-control" id="cardExp" name="card_exp" value="{{ old('card_exp') }}" placeholder="MM/YY">
                                @error('card_exp') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cardCvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cardCvv" name="card_cvv" value="{{ old('card_cvv') }}" placeholder="CVV">
                                @error('card_cvv') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-3" type="submit">Pesan Sekarang</button>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            @forelse($cart->items as $item)
                                @if($item->itemable)
                                    <li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div>
                                            <h6 class="my-0">{{ $item->itemable->name }}</h6>
                                            <small class="text-muted">{{ $item->quantity }} x Rp.{{ number_format($item->itemable->price, 0, ',', '.') }}</small>
                                        </div>
                                        <span class="text-muted">Rp.{{ number_format($item->itemable->price * $item->quantity, 0, ',', '.') }}</span>
                                    </li>
                                @else
                                    <li class="list-group-item d-flex justify-content-between bg-warning-subtle lh-sm">
                                        <div>
                                            <h6 class="my-0 text-danger">Produk Tidak Ditemukan</h6>
                                            <small class="text-muted">Item ini mungkin sudah dihapus.</small>
                                        </div>
                                        <span class="text-muted">N/A</span>
                                    </li>
                                @endif
                            @empty
                                <li class="list-group-item">Keranjang kosong.</li>
                            @endforelse

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>Rp.{{ number_format($subtotal, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Ongkir</span>
                                <strong>Rp.{{ number_format($shippingCost, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <span class="fw-bold">Total Pembayaran</span>
                                <strong class="fw-bold">Rp.{{ number_format($total, 0, ',', '.') }}</strong>
                            </li>
                        </ul>
                        <div class="alert alert-info mt-3" role="alert">
                            Gratis ongkir untuk pesanan di atas Rp.{{ number_format($freeShippingThreshold, 0, ',', '.') }}!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggle Credit Card -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="payment_method"]');
            const ccFields = document.getElementById('creditCardFields');

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    ccFields.style.display = this.value === 'credit_card' ? 'block' : 'none';
                });
            });
        });
    </script>
    @endpush
    
</x-layout>
