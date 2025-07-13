<x-layout>
    <x-slot name="title">Checkout</x-slot>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-7">
                <h4 class="mb-4">Detail Penagihan</h4>
                {{-- Ubah form ini menjadi form Laravel yang sebenarnya --}}
                <form action="{{ route('checkout.store') }}" method="POST"> {{-- Asumsi Anda punya route checkout.store --}}
                    @csrf
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', auth()->guard('customer')->user()->name ?? '') }}" placeholder="Masukkan nama lengkap Anda" required>
                        @error('fullname') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->guard('customer')->user()->email ?? '') }}" placeholder="anda@contoh.com" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Jl. Contoh 1234" required>
                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="Kota" required>
                        @error('city') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" placeholder="Provinsi" required>
                            @error('state') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}" placeholder="Kode Pos" required>
                            @error('zip') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <hr class="my-4">
                    <h5 class="mb-3">Pembayaran</h5>
                    <div class="mb-3">
                        <label for="cardName" class="form-label">Nama di Kartu</label>
                        <input type="text" class="form-control" id="cardName" name="card_name" placeholder="Nama sesuai kartu">
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Nomor Kartu Kredit</label>
                        <input type="text" class="form-control" id="cardNumber" name="card_number" placeholder="Nomor kartu">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cardExp" class="form-label">Masa Berlaku</label>
                            <input type="text" class="form-control" id="cardExp" name="card_exp" placeholder="MM/YY">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cardCvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cardCvv" name="card_cvv" placeholder="CVV">
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" type="submit">Pesan Sekarang</button>
                </form>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            @forelse($cart->items as $item)
                                @if($item->itemable) {{-- Penting: Pastikan itemable tidak null --}}
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
</x-layout>