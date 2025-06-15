# 📦 Sistem Pengelolaan Bahan Baku Terasi Berbasis Just In Time (JIT)

## 📘 Deskripsi Singkat
Sistem ini dirancang untuk membantu industri terasi dalam mengelola persediaan bahan baku (udang rebon dan garam) secara efisien dengan pendekatan **Supply Chain Management (SCM)** dan penerapan metode **Just In Time (JIT)**. Sistem berbasis web ini memungkinkan pemantauan, pencatatan, dan pengelolaan transaksi bahan baku dengan data yang akurat dan real-time.

## 🧪 Tujuan Penelitian
- Mengoptimalkan kuantitas pemesanan bahan baku.
- Menekan biaya persediaan dan penyimpanan.
- Meningkatkan efisiensi pengelolaan logistik dan produksi.
- Membangun sistem berbasis web yang mudah digunakan oleh admin dan staff.

## 🔎 Metode Penelitian
- **Jenis Penelitian:** Kuantitatif Deskriptif
- **Metode Analisis:** EOQ (Economic Order Quantity) dan Just In Time (JIT)
- **Sumber Data:** Observasi, Wawancara, Studi Literatur

## 🔁 Alur Sistem
1. Input data bahan baku dan supplier.
2. Catat transaksi bahan baku masuk dan keluar.
3. Sistem menghitung kebutuhan optimal dan jadwal pengiriman berdasarkan JIT.
4. Laporan dan grafik disajikan secara otomatis.

## 📊 Fitur Sistem
- Master Data Bahan Baku dan Supplier
- Transaksi Masuk & Keluar Bahan Baku
- Laporan Masuk & Keluar
- Grafik Pemantauan Persediaan
- Manajemen Akun
- Perhitungan EOQ dan JIT otomatis
- Export laporan (PDF)

## ⚙️ Teknologi yang Digunakan
- Laravel (Backend Framework)
- MySQL (Database)
- Blade Template (Frontend)
- UML Tools (Diagram Use Case, Activity, Flowchart)
- Excel (Pengujian perhitungan JIT/EOQ)

## 📈 Perhitungan JIT & EOQ
- **Bahan Baku Udang Rebon:**
  - Kuantitas optimal: 96,772 kg (EOQ)
  - Frekuensi pesan (JIT): 2 kali/tahun
  - Total biaya persediaan (JIT): Rp 342.089
- **Bahan Baku Garam:**
  - Kuantitas optimal: 87,120 kg (EOQ)
  - Frekuensi pesan (JIT): 7 kali/tahun
  - Total biaya persediaan (JIT): Rp 164.658,31

## ✅ Uji Validitas
Metode JIT menunjukkan hasil penghematan biaya dan frekuensi pengiriman yang lebih efisien dibanding kondisi aktual tahun 2024. Berdasarkan perhitungan, metode ini “**Sangat Valid**” untuk diterapkan pada industri terasi.

## 👩‍💻 Pengguna Sistem
- **Admin (Owner):** Penuh kontrol atas seluruh data dan proses
- **User (Staff/Pegawai):** Akses transaksi dan laporan, tanpa manajemen akun

## 📂 Struktur Direktori Utama

```
📁 app
📁 public
📁 resources
  └── views
📁 routes
📁 database
  └── migrations
📄 README.md
```
