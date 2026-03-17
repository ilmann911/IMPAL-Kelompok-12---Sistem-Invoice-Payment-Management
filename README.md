# 🚀 Tugas Besar: [System Invoice & Payment Management]
> **Dosen Pengampu:** Muhammad Shiddiq Azis, S.T., MBA
---
## 📊 Perancangan Sistem (DFD)
### DFD Level 0
![DFD Level 0](path/ke/gambar/dfd0.png)
*Diagram Konteks yang menunjukkan aliran data global.*
### DFD Level 1
![DFD Level 1](path/ke/gambar/dfd1.png)
```mermaid
graph TD
    %% Entitas Luar
    Customer[Pelanggan]
    Admin[Admin / Finance]

    %% Proses Utama
    P1((1.0 Proses Pesanan))
    P2((2.0 Catat Pembayaran))
    P3((3.0 Buat Laporan))

    %% Data Store
    DS1[(D1. INVOICES)]
    DS2[(D2. PAYMENTS)]

    %% Aliran Data
    Customer -->|Data Pesanan| P1
    P1 -->|Detail Invoice| DS1
    DS1 -->|Tampilkan Invoice| Customer

    Customer -->|Bukti Bayar| P2
    P2 -->|Verifikasi Status| DS1
    P2 -->|Simpan Data Bayar| DS2
    P2 -->|Notifikasi Bayar| Admin

    Admin -->|Request Laporan| P3
    P3 -->|Ambil Data Invoice| DS1
    P3 -->|Ambil Data Bayar| DS2
    P3 -->|Laporan Keuangan| Admin

*Detail proses bisnis dan integrasi database.*
---
## 🎨 Mockup Antarmuka
Rancangan UI aplikasi yang berfokus pada pengalaman pengguna.
| Login Page | Dashboard | Core Feature |
| :---: | :---: | :---: |
| ![Login](assets/login.png) | ![Dash](assets/dash.png) | ![Feature](assets/feature.png) |
---
## 🛠️ Stack Teknologi
- **Frontend:** Next.js / Java Swing
- **Backend:** Node.js / Java
- **Database:** PostgreSQL / MySQL
---
## 📂 Cara Instalasi
1. `git clone [url-repo]`
2. `npm install` (atau sesuaikan dengan environment)
3. `npm run dev
