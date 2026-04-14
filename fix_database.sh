#!/bin/bash

# Script untuk memperbaiki foreign key error
# Jalankan dengan: bash fix_database.sh

echo ""
echo "============================================"
echo "  Memperbaiki Foreign Key Error Database"
echo "============================================"
echo ""

# Reset database dan jalankan migration fresh
echo "Menjalankan migration fresh..."
php artisan migrate:fresh

echo ""
echo "Menjalankan database seeder..."
php artisan db:seed

echo ""
echo "============================================"
echo "  ✅ Database sudah diperbaiki!"
echo "============================================"
echo ""
echo "Data siswa sudah ditambahkan:"
echo "- Muhammad Ali (ID: 1)"
echo "- Siti Nurhaliza (ID: 2)"
echo "- Ahmad Reza (ID: 3)"
echo ""
echo "Silakan coba lakukan absensi di aplikasi."
echo ""
