<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function showAbsenMasuk()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::find($siswaId);
        
        // Cek apakah sudah absen hari ini
        $absenHariIni = Absensi::where('siswa_id', $siswaId)
                               ->where('tanggal', date('Y-m-d'))
                               ->first();
        
        return view('absen-masuk', compact('siswa', 'absenHariIni'));
    }

    public function user()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::find($siswaId);
        
        // Hitung statistik
        $hadir = Absensi::where('siswa_id', $siswaId)
                        ->where('status', 'Hadir')
                        ->count();
        $terlambat = Absensi::where('siswa_id', $siswaId)
                            ->where('status', 'Terlambat')
                            ->count();
        $izin = Absensi::where('siswa_id', $siswaId)
                       ->where('status', 'Izin')
                       ->count();
        
        $total = $hadir + $terlambat + $izin;
        $persentase = $total > 0 ? round(($hadir / $total) * 100) : 0;
        
        $data = [
            'siswa' => $siswa,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'total' => $total,
            'persentase' => $persentase
        ];

        return view('user', $data);
    }

    public function showAbsenPulang()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::find($siswaId);
        
        // Ambil data absen hari ini
        $absenHariIni = Absensi::where('siswa_id', $siswaId)
                               ->where('tanggal', date('Y-m-d'))
                               ->first();
        
        return view('absen-pulang', compact('siswa', 'absenHariIni'));
    }

    public function dashboard()
    {
        // Ambil data siswa dari auth user atau session
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::find($siswaId);
        
        // Hitung statistik
        $hadir = Absensi::where('siswa_id', $siswaId)
                        ->where('status', 'Hadir')
                        ->count();
        $terlambat = Absensi::where('siswa_id', $siswaId)
                            ->where('status', 'Terlambat')
                            ->count();
        $izin = Absensi::where('siswa_id', $siswaId)
                       ->where('status', 'Izin')
                       ->count();
        
        $total = $hadir + $terlambat + $izin;
        $persentase = $total > 0 ? round(($hadir / $total) * 100) : 0;
        
        $data = [
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'persentase' => $persentase,
            'siswa' => $siswa
        ];

        return view('dashboard', $data);
    }

    public function absenMasuk(Request $request)
    {
        try {
            $siswaId = Auth::user()->siswa_id ?? 1;
            
            // Validasi
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Upload foto
            $foto = $request->file('foto');
            $namaFoto = time().'_masuk.'.$foto->extension();
            $foto->move(public_path('foto_absen'), $namaFoto);

            // Cek apakah sudah ada absen hari ini
            $cekAbsen = Absensi::where('siswa_id', $siswaId)
                              ->where('tanggal', date('Y-m-d'))
                              ->first();

            if ($cekAbsen) {
                return back()->with('error', 'Anda sudah melakukan absen masuk hari ini');
            }

            // Tentukan status berdasarkan jam
            $jamMasuk = date('H:i:s');
            $jamTetap = '08:00:00';
            $status = ($jamMasuk > $jamTetap) ? 'Terlambat' : 'Hadir';

            Absensi::create([
                'siswa_id' => $siswaId,
                'tanggal' => date('Y-m-d'),
                'jam_masuk' => $jamMasuk,
                'status' => $status,
                'foto_absen' => $namaFoto,
                'lokasi' => $request->lokasi ?? null
            ]);

            return back()->with('success', 'Absen masuk berhasil dicatat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function absenPulang()
    {
        try {
            $siswaId = Auth::user()->siswa_id ?? 1;
            
            $absen = Absensi::where('siswa_id', $siswaId)
                           ->where('tanggal', date('Y-m-d'))
                           ->first();

            if (!$absen) {
                return back()->with('error', 'Anda belum melakukan absen masuk hari ini');
            }

            if ($absen->jam_pulang) {
                return back()->with('error', 'Anda sudah melakukan absen pulang hari ini');
            }

            $absen->update([
                'jam_pulang' => date('H:i:s')
            ]);

            return back()->with('success', 'Absen pulang berhasil dicatat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $data = Absensi::where('siswa_id', $siswaId)
                       ->orderBy('tanggal', 'desc')
                       ->get();
        
        return view('riwayat', compact('data'));
    }

    public function laporan()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::find($siswaId);
        $data = Absensi::where('siswa_id', $siswaId)
                       ->orderBy('tanggal', 'desc')
                       ->get();
        
        return view('laporan', compact('data', 'siswa'));
    }

    public function exportPDF()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $data = Absensi::where('siswa_id', $siswaId)
                       ->orderBy('tanggal', 'desc')
                       ->get();
        
        // Menggunakan laravel-dompdf atau manual PDF creation
        $html = view('laporan', compact('data'));
        
        // Jika tidak punya dompdf library, return view biasa sebagai PDF fallback
        return $html;
    }
}