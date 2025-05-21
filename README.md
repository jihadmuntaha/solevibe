# PHB Ecommerce

Proyek ini merupakan aplikasi ecommerce sederhana yang dikembangkan sebagai bahan ajar untuk mata kuliah **Pemrograman Web 2** di Politeknik Harapan Bersama Tegal.

## Fitur Utama

- Manajement Product Category
- Manajemen Product
- Login & Register Customer
- Keranjang belanja
- Proses checkout
- Dashboard Customer
## Instalasi

1. Clone repository ini:
    ```bash
    git clone https://github.com/jamalapriadi/phb_ecommerce.git
    cd phb_ecommerce
    ```
2. Jalankan perintah berikut untuk menginstall dependency PHP:
    ```bash
    composer install
    ```
3. Jalankan perintah berikut untuk menginstall dependency frontend dan menjalankan development server:
    ```bash
    npm install
    ```
4. Atur konfigurasi database pada file `.env` sesuai dengan pengaturan database Anda.
5. Jalankan migrasi database:
    ```bash
    php artisan migrate
    ```
6. Jalankan perintah berikut untuk membuka hasilnya di browser:
    ```bash
    composer run dev
    ```

## Kontribusi

Kontribusi sangat terbuka untuk pengembangan lebih lanjut. Silakan buat pull request atau issue.

## Lisensi

Proyek ini hanya digunakan untuk keperluan pembelajaran.