# 🎁 Aplikasi E-Commerce UMKM Toko Oleh-Oleh Mojokerto

Edo Kurniawan
24081010269

Selamat datang di repositori proyek **Toko Oleh-Oleh Mojokerto**. Aplikasi ini dirancang sebagai platform digital untuk membantu pelaku UMKM dalam mengelola stok produk serta memudahkan pelanggan melakukan pemesanan produk khas daerah secara daring.

| Peran (Role)      | Username     | Password    | Hak Akses Utama                             |
| :---------------- | :----------- | :---------- | :------------------------------------------ |
| **Administrator** | `superAdmin` | `admin`     | Manajemen produk, kategori, user, & pesanan |
| **Pelanggan**     | `pelanggan`  | `pelanggan` | Belanja, manajemen keranjang, & checkout    |

---

## 📁 Struktur Folder Proyek

```text
umkm-toko-oleh-oleh/
├── admin/            # Dashboard & Manajemen Data (Backend)
│   ├── action/       # Logika PHP CRUD (Tambah, Edit, Hapus)
│   └── components/   # Potongan UI Admin (Header, Sidebar, Navbar)
├── assets/           # Media statis & hasil unggahan gambar produk
├── config/           # File koneksi database & skrip SQL
├── user/             # Library & aset untuk tampilan pengguna
├── index.php         # Katalog produk untuk pengunjung
├── login.php         # Pintu masuk sistem (Admin & User)
├── cart.php          # Manajemen item belanja
└── checkout.php      # Finalisasi pesanan & transaksi
```
