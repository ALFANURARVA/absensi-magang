# 📋 Panduan Memperbaiki Foreign Key Error

Error yang Anda hadapi:
```
SQLSTATE[23000]: Integrity constraint violation: 1452 
Cannot add or update a child row: a foreign key constraint fails
```

Ini berarti tidak ada data siswa dengan ID 1 di database.

## ✅ Solusi - Jalankan Perintah Berikut:

### 1. **Reset Database (Hapus semua data dan jalankan fresh migration)**
```bash
cd c:\XAMPP2\htdocs\absen_magang\absen-magang

# Pilih A untuk jawab "yes" jika diminta
php artisan migrate:fresh
```

### 2. **Jalankan Seeder untuk Menambah Data Siswa**
```bash
php artisan db:seed
```

### 3. **Alternatif - Jika Hanya Ingin Menambah Data Tanpa Reset**
```bash
php artisan migrate
php artisan db:seed
```

## 📊 Data yang Akan Dibuat:

Setelah menjalankan seeder, akan ada 3 siswa:

| ID | Nama | NIS | Jurusan | Tempat Magang |
|----|------|-----|---------|---------------|
| 1  | Muhammad Ali | 001 | Teknik Informatika | PT. Maju Jaya |
| 2  | Siti Nurhaliza | 002 | Sistem Informasi | PT. Digital Indonesia |
| 3  | Ahmad Reza | 003 | Teknik Komputer | CV. Digital Maju |

## 🔧 Yang Sudah Diperbaiki:

1. ✅ **Migration Baru**: `2026_04_11_085000_update_siswas_table.php`
   - Menambah kolom: nama, nis, jurusan, tempat_magang

2. ✅ **DatabaseSeeder Updated**: 
   - Menambah 3 data siswa dummy dengan ID 1, 2, 3

3. ✅ **Siswa Model Fixed**:
   - Table name diubah dari 'siswa' menjadi 'siswas'

## 🚀 Setelah Menjalankan Perintah Diatas:

Coba kembali lakukan absensi - error harus hilang!

## ⚠️ Troubleshooting:

Jika masih error:
1. Pastikan MySQL server berjalan
2. Cek konfigurasi `.env` - pastikan DB_HOST, DB_USER, DB_PASSWORD benar
3. Jalankan `php artisan cache:clear` untuk clear cache
4. Coba `php artisan migrate:fresh --seed` untuk reset dan seed sekaligus
