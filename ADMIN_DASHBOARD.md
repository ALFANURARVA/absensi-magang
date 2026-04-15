# Panduan Admin Dashboard

## Login Admin

Untuk mengakses dashboard admin, silakan masuk ke:
```
http://localhost/absen_magang/absen-magang/admin/login
```

### Kredensial Default Admin:
- **Email**: `admin@absensi.com`
- **Password**: `admin12345`

## Fitur Admin Dashboard

### 1. Dashboard Utama
Menampilkan statistik ringkas:
- Total Siswa Magang
- Total Hadir
- Total Tidak Hadir
- Total Absensi

### 2. Data Siswa Magang
Fitur untuk mengelola dan melihat data seluruh siswa magang:
- **Search/Filter**: Cari siswa berdasarkan nama atau NISN
- **Filter Jurusan**: Filter siswa berdasarkan jurusan
- **Detail Siswa**: Lihat detail dan riwayat absensi per siswa dengan statistik kehadiran

### 3. Data Absensi
Melihat dan memfilter data absensi dari seluruh siswa:
- **Filter Siswa**: Pilih siswa spesifik
- **Filter Status**: Lihat hanya data hadir atau tidak hadir
- **Filter Tanggal**: Tentukan rentang tanggal
- **Export CSV**: Export data absensi ke format CSV untuk keperluan laporan

### 4. Laporan Kehadiran
Laporan ringkas kehadiran per siswa:
- **Detail per Siswa**: Lihat total absensi, hadir, dan tidak hadir
- **Persentase Kehadiran**: Persentase kehadiran (warna hijau ≥80%, kuning ≥60%, merah <60%)
- **Filter Jurusan**: Filter laporan berdasarkan jurusan

## Fitur Keamanan

- **Role-based Access**: Hanya user dengan role 'admin' yang dapat mengakses fitur admin
- **Middleware Protection**: Semua rute admin dilindungi dengan middleware `admin_role`
- **Session Management**: Logout otomatis saat meninggalkan halaman admin

## Informasi Teknis

### Struktur Database
- **Field 'role' pada users table**: Enum dengan nilai 'siswa' atau 'admin'
- Setiap user admin adalah user terpisah (tidak terikat ke siswa)

### Routes Admin
- `GET /admin/login` - Halaman login admin
- `POST /admin/login` - Proses login
- `GET /admin/dashboard` - Dashboard utama
- `GET /admin/siswa` - Daftar siswa
- `GET /admin/siswa/{id}` - Detail siswa
- `GET /admin/absensi` - Data absensi dengan filter
- `GET /admin/absensi/export` - Export data absensi
- `GET /admin/laporan` - Laporan kehadiran
- `POST /admin/logout` - Logout admin

## Tips Penggunaan

1. **Backup Data**: Gunakan fitur Export CSV untuk backup data absensi secara berkala
2. **Filter Data**: Gunakan filter tanggal untuk membuat laporan bulanan/mingguan
3. **Monitoring**: Monitor persentase kehadiran siswa melalui halaman laporan
4. **Detail Siswa**: Klik nama siswa di daftar untuk melihat riwayat absensi lengkap

## Troubleshooting

### Jika tidak bisa login:
- Pastikan email dan password sesuai dengan kredensial
- Cek bahwa user memiliki role 'admin'
- Coba clear cache: `php artisan cache:clear`

### Jika data tidak terlihat:
- Pastikan sudah menjalankan migration dan seeding
- Cek bahwa ada data siswa dan absensi di database
- Refresh halaman atau clear browser cache

### Jika middleware error:
- Pastikan file `app/Http/Middleware/AdminRole.php` ada
- Cek bahwa middleware sudah terdaftar di `bootstrap/app.php`
- Jalankan: `php artisan config:cache`
