# RuangKata
RuangKata adalah platform website artikel interaktif berbasis Laravel 12 yang dirancang khusus untuk mahasiswa Fakultas Ilmu Komputer dan Teknologi Informasi Universitas Gunadarma. Platform ini menyediakan wadah untuk mempublikasikan tulisan bertema teknologi, serta mendukung interaksi sosial melalui fitur komentar, clap/unclap, dan follow antar pengguna. RuangKata bertujuan mendorong pengembangan kemampuan menulis teknis dan kolaborasi di lingkungan akademik.

## Persyaratan
- PHP `^8.2`
- Composer `2.x`
- Node.js `^18`
- npm `^9`

## Fitur
🔐 Autentikasi Pengguna
- Registrasi, login, dan logout
- Fitur lupa kata sandi (reset password)

📝 Manajemen Artikel
- Membuat, mengedit, dan menghapus artikel bertema teknologi
- Editor WYSIWYG untuk penulisan konten yang terstruktur
- Kategorisasi artikel berdasarkan topik
- Artikel tampil secara publik di halaman utama

💬 Interaksi Sosial
- Clap/unclap pada artikel
- Komentar pada artikel
- Fitur follow antar pengguna

👤 Profil Pengguna
- Lihat dan perbarui profil
- Tampilkan daftar artikel yang pernah ditulis

🛠️ Dasbor Admin
- Kelola pengguna, kategori artikel, dan laporan konten
- Hak akses untuk mengubah dan menghapus data

🚩 Lapor Konten
- Fitur pelaporan artikel atau komentar yang melanggar
- Notifikasi laporan diteruskan ke dashboard admin

🖼️ Manajemen Media
- Unggah gambar pendukung dalam artikel
- File media tersimpan dan terstruktur secara otomatis

🔒 Manajemen Sesi
- Manajemen sesi aman untuk pengguna dan admin
- Fitur logout untuk mengakhiri sesi aktif

## Langkah-langkah Menjalankan Proyek Secara Lokal:
1. Tekan tombol `<> Code`
2. Salin link repository menggunakan HTTPS atau SSH
3. Jalankan perintah `git clone` di terminal Anda.
4. Masuk ke folder proyek hasil clone
5. Instal semua dependensi backend dengan perintah `composer install`
6. Instal semua dependensi frontend dengan perintah `npm install`
7. Buat file .env dengan perintah `cp .env.example .env`, lalu isi konfigurasi yang diperlukan
8. Generate application key dengan menjalankan `php artisan key:generate`
9. Jalankan perintah `php artisan storage:link` untuk menghubungkan direktori penyimpanan
10. Lakukan migrasi database dengan perintah `php artisan migrate`
11. (Opsional) Isi data awal ke dalam database dengan perintah `php artisan db:seed`
12. Compile aset frontend dengan perintah `npm run dev`
13. Jalankan aplikasi dengan perintah `php artisan serve`
14. Aplikasi RuangKata akan dapat diakses melalui browser di alamat "http://localhost:8000"

## Akun Admin

Untuk membuat akun admin, jalankan perintah berikut di terminal: `php artisan make:admin`

## Screenshots Halaman Pengguna
**Halaman Beranda**
![Halaman Beranda](./dokumentasi_ss/a.pengguna_halaman_beranda.jpg)

**Halaman Tentang**
![Halaman Tentang](./dokumentasi_ss/b.pengguna_halaman_tentang.jpg)

**Halaman Buat Akun**
![Halaman Buat Akun](./dokumentasi_ss/c.pengguna_halaman_buat_akun.jpg)

**Halaman Masuk**
![Halaman Masuk](./dokumentasi_ss/d.pengguna_halaman_masuk.jpg)

**Halaman Profil Pengguna**
![Halaman Profil Pengguna](./dokumentasi_ss/e.pengguna_halaman_profil_pengguna.jpg)

**Halaman Reset Kata Sandi**
![Halaman Reset Kata Sandi](./dokumentasi_ss/f.pengguna_halaman_reset_kata_sandi.jpg)

**Halaman Kata Sandi Baru**
![Halaman Kata Sandi Baru](./dokumentasi_ss/g.pengguna_halaman_kata_sandi_baru.jpg)

**Halaman Lihat Post**
![Halaman Lihat Post](./dokumentasi_ss/h.pengguna_halaman_lihat_post.jpg)

**Halaman Cari Post**
![Halaman Cari Post](./dokumentasi_ss/i.pengguna_halaman_cari_post.jpg)

**Halaman Buat Post**
![Halaman Buat Post](./dokumentasi_ss/j.pengguna_halaman_buat_post.jpg)

**Halaman Ubah Post**
![Halaman Ubah Post](./dokumentasi_ss/k.pengguna_halaman_ubah_post.jpg)

**Halaman Lapor**
![Halaman Lapor](./dokumentasi_ss/l.pengguna_halaman_lapor.jpg)

**Halaman Pengaturan**
![Halaman Pengaturan](./dokumentasi_ss/m.pengguna_halaman_pengaturan.jpg)

## Screenshots Halaman Admin
**Halaman Masuk**
![Halaman Masuk](./dokumentasi_ss/a.admin_halaman_masuk.jpg)

**Halaman Dasbor**
![Halaman Dasbor](./dokumentasi_ss/b.admin_halaman_dasbor.jpg)

**Halaman List Kategori**
![Halaman List Kategori](./dokumentasi_ss/c.admin_halaman_list_kategori.jpg)

**Halaman Buat Kategori**
![Halaman Buat Kategori](./dokumentasi_ss/d.admin_halaman_buat_kategori.jpg)

**Halaman Ubah Kategori**
![Halaman Ubah Kategori](./dokumentasi_ss/e.admin_halaman_ubah_kategori.jpg)

**Halaman List Pengguna**
![Halaman List Pengguna](./dokumentasi_ss/f.admin_halaman_list_pengguna.jpg)

**Halaman Buat Pengguna**
![Halaman Buat Pengguna](./dokumentasi_ss/g.admin_halaman_buat_pengguna.jpg)

**Halaman Ubah Pengguna**
![Halaman Ubah Pengguna](./dokumentasi_ss/h.admin_halaman_ubah_pengguna.jpg)

**Halaman List Laporan Post**
![Halaman List Laporan Post](./dokumentasi_ss/i.admin_halaman_list_laporan_post.jpg)

**Halaman Detail Laporan Post**
![Halaman Detail Laporan Post](./dokumentasi_ss/j.admin_halaman_detail_laporan_post.jpg)

**Halaman List Laporan Komentar**
![Halaman List Laporan Komentar](./dokumentasi_ss/k.admin_halaman_list_laporan_komentar.jpg)

**Halaman Detail Laporan Komentar**
![Halaman Detail Laporan Komentar](./dokumentasi_ss/l.admin_halaman_detail_laporan_komentar.jpg)