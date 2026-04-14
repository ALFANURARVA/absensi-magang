# 🔧 SOLUSI FOREIGN KEY ERROR - LANGKAH DEMI LANGKAH

## 📌 MASALAH
Foreign key constraint violation karena tidak ada data siswa dengan ID 1 di database.

## ✅ SOLUSI - PILIH SALAH SATU:

### **OPSI 1: Windows Users (PALING MUDAH)**
1. Buka folder: `c:\XAMPP2\htdocs\absen_magang\absen-magang`
2. Double-click file: `fix_database.bat`
3. Tunggu hingga selesai dan tekan sembarang tombol
4. ✅ Database sudah diperbaiki!

### **OPSI 2: Command Line (Windows/Mac/Linux)**
Buka terminal/command prompt, arahkan ke folder project:
```bash
cd c:\XAMPP2\htdocs\absen_magang\absen-magang
```

Jalankan command:
```bash
php artisan migrate:fresh --seed
```

Atau jalankan satu per satu:
```bash
php artisan migrate:fresh
php artisan db:seed
```

### **OPSI 3: Linux/Mac Users**
```bash
cd /path/to/absen-magang
bash fix_database.sh
```

## 📋 APA YANG DILAKUKAN SCRIPT INI:

1. **Menjalankan Migration Fresh**
   - Menghapus semua tabel lama
   - Membuat tabel baru dengan struktur yang benar
   - Menambah kolom: nama, nis, jurusan, tempat_magang di tabel siswas

2. **Menjalankan Database Seeder**
   - Membuat 3 data siswa:
     - ID 1: Muhammad Ali
     - ID 2: Siti Nurhaliza
     - ID 3: Ahmad Reza

## 📊 DATA YANG AKAN DIBUAT

```
Tabel: siswas
┌────┬────────────────────┬─────┬─────────────────────┬─────────────────────┐
│ ID │ Nama               │ NIS │ Jurusan             │ Tempat Magang       │
├────┼────────────────────┼─────┼─────────────────────┼─────────────────────┤
│ 1  │ Muhammad Ali       │ 001 │ Teknik Informatika  │ PT. Maju Jaya       │
│ 2  │ Siti Nurhaliza     │ 002 │ Sistem Informasi    │ PT. Digital Indonesia│
│ 3  │ Ahmad Reza         │ 003 │ Teknik Komputer     │ CV. Digital Maju    │
└────┴────────────────────┴─────┴─────────────────────┴─────────────────────┘
```

## 🎯 FILES YANG SUDAH DIPERBARUI

1. ✅ `database/migrations/2026_04_11_085000_update_siswas_table.php` (BARU)
   - Menambah kolom ke tabel siswas

2. ✅ `database/seeders/DatabaseSeeder.php` (UPDATED)
   - Menambah 3 data siswa dummy

3. ✅ `app/Models/Siswa.php` (FIXED)
   - Table name dari 'siswa' → 'siswas'

4. ✅ `fix_database.bat` (BARU - Windows script)
5. ✅ `fix_database.sh` (BARU - Linux/Mac script)
6. ✅ `FIX_FOREIGN_KEY_ERROR.md` (DOKUMENTASI)

## 🚀 TESTING SETELAH PERBAIKAN

1. Buka aplikasi di browser
2. Coba klik tombol "Absen Masuk"
3. Upload foto
4. Klik "Absen Masuk"

**Error harus hilang sekarang!** ✅

## 🆘 JIKA MASIH ERROR

Coba langkah troubleshooting:

```bash
# Clear cache
php artisan cache:clear

# Optimize
php artisan optimize

# Cek migration status
php artisan migrate:status

# Reset dan jalankan ulang
php artisan migrate:reset
php artisan migrate:fresh
php artisan db:seed
```

## 💡 CATATAN PENTING

- **Siswa Default**: ID 1 digunakan oleh controller saat user belum login
- **Produksi**: Ganti hardcoded siswa_id dengan auth user ID saat production
- **Security**: Untuk production, tambahkan authentication dan ubah penggunaan siswa_id

---

**Pertanyaan?** Cek dokumentasi di folder project atau hubungi tim development.
