<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalSiswa = Siswa::count();
        $totalAbsensi = Absensi::count();
        $totalHadir = Absensi::where('status', 'hadir')->count();
        $totalTidakHadir = Absensi::where('status', 'tidak hadir')->count();
        $siswas = Siswa::paginate(10);

        return view('admin.dashboard', compact('totalSiswa', 'totalAbsensi', 'totalHadir', 'totalTidakHadir', 'siswas'));
    }

    /**
     * Show all siswa
     */
    public function siswa(Request $request)
    {
        $query = Siswa::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%")
                  ->orWhere('jurusan', 'like', "%$search%");
        }

        // Filter by jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->input('jurusan'));
        }

        $siswas = $query->paginate(15);
        $jurusans = Siswa::distinct()->pluck('jurusan');

        return view('admin.siswa', compact('siswas', 'jurusans'));
    }

    /**
     * Show siswa detail with absensis
     */
    public function siswaDetail($id)
    {
        $siswa = Siswa::findOrFail($id);
        $absensis = Absensi::where('siswa_id', $id)->paginate(20);

        return view('admin.siswa-detail', compact('siswa', 'absensis'));
    }

    /**
     * Show all attendance data
     */
    public function absensi(Request $request)
    {
        $query = Absensi::with('siswa');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_sampai'));
        }

        // Filter by siswa
        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->input('siswa_id'));
        }

        $absensis = $query->orderBy('tanggal', 'desc')->paginate(20);
        $siswas = Siswa::all();

        return view('admin.absensi', compact('absensis', 'siswas'));
    }

    /**
     * Export data to CSV
     */
    public function exportAbsensi(Request $request)
    {
        $query = Absensi::with('siswa');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_sampai'));
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->input('siswa_id'));
        }

        $absensis = $query->orderBy('tanggal', 'desc')->get();

        $csv = "NISN,Nama Siswa,Tanggal,Waktu,Status,Jam,Tempat Magang\n";
        foreach ($absensis as $absensi) {
            $csv .= "\"{$absensi->siswa->nis}\",\"{$absensi->siswa->nama}\",\"{$absensi->tanggal}\",\"{$absensi->waktu}\",\"{$absensi->status}\",\"{$absensi->jam}\",\"{$absensi->siswa->tempat_magang}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="data_absensi_' . date('Y-m-d_H-i-s') . '.csv"');
    }

    /**
     * Show laporan (report)
     */
    public function laporan(Request $request)
    {
        $query = Siswa::withCount('absensi as total_absensi')
            ->withCount(['absensi as total_hadir' => function ($q) {
                $q->where('status', 'hadir');
            }])
            ->withCount(['absensi as total_tidak_hadir' => function ($q) {
                $q->where('status', 'tidak hadir');
            }]);

        // Filter by jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->input('jurusan'));
        }

        $siswas = $query->get();
        $jurusans = Siswa::distinct()->pluck('jurusan');

        return view('admin.laporan', compact('siswas', 'jurusans'));
    }
}
