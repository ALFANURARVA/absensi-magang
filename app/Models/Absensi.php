<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'foto_absen',
        'lokasi'
    ];

    /**
     * Get the siswa associated with this absensi.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}