# 🍃 Libas Street Coffee — Panduan Setup & Penggunaan

## ✅ Persyaratan
- XAMPP (PHP 8.2+, MySQL/MariaDB)
- Database: `libas_kopi` (sudah dibuat otomatis via migrate)

## 🚀 Setup Awal (sudah selesai)
```
1. migrate:fresh --seed  ✅ DONE
2. storage:link          ✅ DONE  
3. optimize:clear        ✅ DONE
```

## 🌐 URL Akses
- **Landing Page:**  http://localhost/Laravel/libas_cafe/public
- **Login:**         http://localhost/Laravel/libas_cafe/public/login
- **Register:**      http://localhost/Laravel/libas_cafe/public/register
- **Admin Panel:**   http://localhost/Laravel/libas_cafe/public/admin/dashboard
- **Customer:**      http://localhost/Laravel/libas_cafe/public/customer/dashboard

## 🔑 Akun Demo
| Role     | Email                      | Password    |
|----------|---------------------------|-------------|
| Admin    | admin@libascafe.com       | admin123    |
| Customer | customer@libascafe.com    | customer123 |

## 📋 Fitur Lengkap

### Admin
- [x] Dashboard dengan chart pendapatan 12 bulan
- [x] Rekap bulanan pesanan + statistik
- [x] Kelola produk (CRUD + upload foto + featured)
- [x] Kelola kategori (Kopi, Non Kopi, Cemilan)
- [x] Kelola pesanan (view, update status, lihat bukti bayar)
- [x] Kelola akun admin & pelanggan (CRUD + aktifkan/nonaktifkan)
- [x] Profil admin

### Pelanggan
- [x] Landing page dengan hero, menu preview, cara pesan
- [x] Registrasi & login
- [x] Dashboard dengan filter kategori & pencarian
- [x] Keranjang belanja (tambah, update qty, hapus, kosongkan)
- [x] Checkout dengan 6 metode pembayaran digital
- [x] Upload bukti transfer
- [x] Struk pembelian (bisa dicetak)
- [x] Riwayat belanja + detail pesanan
- [x] Profil & ganti password

## 🗄️ Database (libas_kopi)
- `users` — admin & pelanggan
- `categories` — Kopi, Non Kopi, Cemilan
- `products` — 20 produk demo
- `orders` — data pesanan
- `order_items` — detail item per pesanan
- `carts` — keranjang belanja

## 🔧 Jika Ada Masalah
```cmd
# Clear semua cache
C:\xampp\php\php.exe artisan optimize:clear

# Re-migrate (HAPUS DATA!)
C:\xampp\php\php.exe artisan migrate:fresh --seed

# Buat storage link ulang
C:\xampp\php\php.exe artisan storage:link
```
