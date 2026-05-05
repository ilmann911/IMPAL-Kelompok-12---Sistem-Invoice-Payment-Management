const express = require('express');
const mysql = require('mysql2');
const bcrypt = require('bcrypt');
const cors = require('cors');

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(express.json()); // Agar bisa membaca request berupa JSON

// Konfigurasi Koneksi Database
// Sesuaikan user dan password dengan pengaturan MySQL kamu (biasanya XAMPP default-nya user: 'root', password: '')
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '', 
    database: 'invopay_db' // Pastikan database ini sudah dibuat di phpMyAdmin
});

// Cek koneksi ke database
db.connect((err) => {
    if (err) {
        console.error('Koneksi database gagal: ', err);
        return;
    }
    console.log('Berhasil terhubung ke database MySQL!');
});

// ==========================================
// 1. ENDPOINT UNTUK REGISTER (Buat Akun)
// ==========================================
app.post('/api/register', async (req, res) => {
    const { name, email, password } = req.body;

    try {
        // Enkripsi password menggunakan bcrypt (SaltRounds = 10)
        const hashedPassword = await bcrypt.hash(password, 10);

        // Masukkan data ke tabel users
        const sql = 'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)';
        db.query(sql, [name, email, hashedPassword], (err, result) => {
            if (err) {
                // Jika email sudah ada (karena UNIQUE constraint di database)
                if (err.code === 'ER_DUP_ENTRY') {
                    return res.status(400).json({ message: 'Email sudah terdaftar!' });
                }
                return res.status(500).json({ message: 'Terjadi kesalahan pada server' });
            }
            res.status(201).json({ message: 'Akun berhasil dibuat!' });
        });
    } catch (error) {
        res.status(500).json({ message: 'Gagal mengenkripsi password' });
    }
});

// ==========================================
// 2. ENDPOINT UNTUK LOGIN
// ==========================================
app.post('/api/login', (req, res) => {
    const { email, password } = req.body;

    // Cari user di database berdasarkan email
    const sql = 'SELECT * FROM users WHERE email = ?';
    db.query(sql, [email], async (err, results) => {
        if (err) return res.status(500).json({ message: 'Terjadi kesalahan pada database' });

        // Jika email tidak ditemukan di database
        if (results.length === 0) {
            return res.status(401).json({ message: 'Email atau password salah!' });
        }

        const user = results[0];

        // Bandingkan password yang diketik dengan password yang di-hash di database
        const isPasswordMatch = await bcrypt.compare(password, user.password_hash);

        if (isPasswordMatch) {
            // Login Berhasil
            res.status(200).json({ 
                message: 'Login sukses!', 
                user: { id: user.user_id, name: user.name, email: user.email } 
            });
        } else {
            // Password salah
            res.status(401).json({ message: 'Email atau password salah!' });
        }
    });
});

// Jalankan Server
app.listen(port, () => {
    console.log(`Server back-end berjalan di http://localhost:${port}`);
});