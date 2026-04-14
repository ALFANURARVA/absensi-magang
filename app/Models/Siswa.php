<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'nis',
        'jurusan',
        'tempat_magang'
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}