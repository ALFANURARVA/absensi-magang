<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function edit()
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::findOrFail($siswaId);
        
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswaId = Auth::user()->siswa_id ?? 1;
        $siswa = Siswa::findOrFail($siswaId);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswas,nis,' . $siswaId,
            'jurusan' => 'required|string|max:255',
            'tempat_magang' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nis.required' => 'NIS tidak boleh kosong',
            'nis.unique' => 'NIS sudah terdaftar untuk siswa lain',
            'jurusan.required' => 'Jurusan tidak boleh kosong',
            'tempat_magang.required' => 'Tempat magang tidak boleh kosong',
        ]);

        $siswa->update($validated);

        return redirect()->route('user')->with('success', 'Data siswa berhasil diperbarui!');
    }
}
