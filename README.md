# Laravel Online Store

Proyek ini adalah sebuah toko online berbasis Laravel yang dibuat untuk belajar pengembangan aplikasi web dengan pola Repository. Fitur utama mencakup katalog produk, keranjang belanja, panel admin, dan integrasi payment gateway Midtrans.

## Fitur Utama

- Online store dengan frontend pengguna
- Panel admin untuk manajemen produk, kategori, dan transaksi
- Pembayaran menggunakan Midtrans
- Data wilayah Indonesia melalui `azishapidin/indoregion`
- Struktur menggunakan Repository Pattern

## Teknologi yang Digunakan

- PHP 7.3 / 8.x
- Laravel `^8.12`
- Bootstrap `^4.6`
- Laravel Mix
- jQuery
- Axios
- Sass
- Midtrans PHP SDK
- `azishapidin/indoregion`
- `webpatser/laravel-uuid`

## Dependensi Utama

- `laravel/framework`
- `laravel/ui`
- `midtrans/midtrans-php`
- `azishapidin/indoregion`
- `webpatser/laravel-uuid`
- `fideloper/proxy`
- `fruitcake/laravel-cors`
- `guzzlehttp/guzzle`

## Instalasi

1. Clone repository
2. Jalankan `composer install`
3. Jalankan `npm install`
4. Copy `.env.example` menjadi `.env`
5. Konfigurasi database dan Midtrans pada file `.env`
6. Jalankan `php artisan key:generate`
7. Jalankan migrasi dan seeder: `php artisan migrate --seed`
8. Compile asset: `npm run dev`

## Catatan

Proyek ini cocok untuk pembelajaran membangun aplikasi e-commerce dengan Laravel dan integrasi payment gateway.
