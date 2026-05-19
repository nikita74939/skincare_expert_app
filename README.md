# SkinWise Expert - Sistem Pakar Rekomendasi Skincare

Teknologi:
- Frontend: HTML, CSS, JavaScript, Bootstrap, jQuery
- Backend: PHP Native
- Database: MySQL
- Metode: Forward Chaining

## Cara Instalasi

1. Copy folder `skincare_expert_app` ke folder server lokal:
   `htdocs/skincare_expert_app`

2. Buka phpMyAdmin, lalu import file:
   `database/skincare.sql`

3. Sesuaikan koneksi database di:
   `config/database.php`

4. Jalankan aplikasi di browser:
   `http://localhost/skincare_expert_app/`

5. Login admin:
   - URL: `http://localhost/skincare_expert_app/admin/login.php`
   - Email: `admin@skinwise.test`
   - Password: `admin123`

## Fitur User
- Landing page
- Konsultasi kondisi kulit
- Proses forward chaining
- Hasil jenis kulit
- Rekomendasi skincare
- Riwayat konsultasi

## Fitur Admin
- Login admin
- Dashboard
- CRUD gejala/kondisi kulit
- CRUD jenis kulit
- Kelola aturan produksi
- CRUD rekomendasi skincare

## Catatan Metode Forward Chaining
Jawaban pengguna yang bernilai “ya” dianggap sebagai fakta awal. Sistem mencocokkan fakta tersebut dengan tabel aturan, lalu memilih jenis kulit dengan tingkat kecocokan aturan tertinggi.
