# 🚀 Tugas Besar: Revenix-Plan-Better-Earn-Better

> **Dosen Pengampu:** Muhammad Shiddiq Azis, S.T., MBA

---

## 📊 Perancangan Sistem (DFD)

### Class Diagram
![Class Diagram](gambar/ClassDiagram.png)


### DFD Level 0
![DFD Level 0](gambar/DFDlevel0.jpg)

Pada diagram ini terdapat dua entitas utama yaitu Admin InvoPay dan Klien. Admin InvoPay berperan penuh dalam mengelola operasional sistem, mulai dari menginput data klien, mengelola data produk atau jasa, hingga membuat invoice baru. Admin juga bertugas melakukan pembaruan status tagihan serta verifikasi pembayaran. Sebagai respons, sistem memberikan keluaran kepada admin berupa dashboard statistik, daftar invoice dan produk, riwayat transaksi, serta laporan keuangan dalam format PDF. Di sisi lain, entitas Klien berinteraksi dengan sistem untuk melakukan konfirmasi metode pembayaran dan mengunggah bukti transfer. Sistem kemudian memberikan balasan kepada klien berupa notifikasi invoice baru, ketersediaan dokumen tagihan (PDF), serta pengingat jatuh tempo.


### DFD Level 1
![DFD Level 1](gambar/DFDlevel1.jpg)

Pada diagram ini, sistem InvoPay diuraikan secara lebih rinci ke dalam 7 proses utama yang menghubungkan entitas dengan basis data sistem:

Proses 1 Manajemen Akun & Login: Digunakan oleh admin untuk melakukan autentikasi ke dalam sistem. Sistem memverifikasi kredensial login dengan data akun admin dan memberikan keluaran berupa status akses login.

Proses 2 Manajemen Produk/Jasa: Memungkinkan admin untuk mengelola (menambah, mengubah, menghapus) katalog informasi produk atau layanan jasa beserta acuan harganya untuk disimpan ke dalam sistem.

Proses 3 Manajemen Klien: Proses yang dilakukan oleh admin untuk mengelola basis data pelanggan (klien). Data klien baru maupun pembaruan informasi profil klien akan divalidasi dan direkam ke dalam database.

Proses 4 Portal Klien: Merupakan antarmuka khusus bagi klien. Melalui portal ini, klien yang telah terautentikasi dapat melihat daftar tagihan (invoice) aktif milik mereka beserta tautan detailnya.

Proses 5 Generate & Update Invoice: Proses inti di mana admin membuat dan mengirimkan tagihan baru dengan menarik referensi dari data produk dan data klien. Sistem menyimpan rincian invoice ke database lalu meneruskan notifikasi serta data tagihan ke Portal Klien.

Proses 6 Konfirmasi & Verifikasi Pembayaran: Menangani alur transaksi masuk. Klien mengunggah bukti pembayaran yang kemudian memicu notifikasi untuk admin. Admin akan meninjau dan memverifikasi bukti tersebut sehingga status invoice di database diperbarui menjadi lunas (Paid).

Proses 7 Laporan & Export PDF: Digunakan oleh admin untuk meminta rekapitulasi data keuangan. Sistem akan menarik data riwayat invoice dan transaksi berdasarkan rentang waktu tertentu, lalu menyajikannya dalam bentuk dokumen (PDF) untuk diunduh.


---

## 🎨 Mockup Antarmuka
Rancangan UI aplikasi yang berfokus pada pengalaman pengguna.

| Login Page | Dashboard | Core Feature |
| :---: | :---: | :---: |
| ![Login](gambar/Login.jpeg) | ![Dash](gambar/Dashboard.jpeg) | ![Feature](gambar/KelolaKlien.jpeg) |

---

## 🛠️ Stack Teknologi
- **Frontend:** PHP
- **Backend:** PHP 
- **Database:** MySQL

---

## 📂 Cara Instalasi
1. `git clone [url-repo]`
2. `npm install` (atau sesuaikan dengan environment)
3. `npm run dev`
