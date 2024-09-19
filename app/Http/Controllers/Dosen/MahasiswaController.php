<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\KelasMahasiswa;

class MahasiswaController extends Controller
{
    public function invite($kode_kelas)
    {
        $validator = Validator::make(request()->all(), [
            'nim' => 'required|exists:mahasiswa,nim',
        ], [
            'required' => ':attribute tidak boleh kosong',
            'exists' => 'Mahasiswa tidak ditemukan'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        KelasMahasiswa::create([
            'kode_kelas' => $kode_kelas,
            'nim' => request()->nim,
            'status' => 'aktif'
        ]);

        Alert::success('Berhasil', 'Mahasiswa berhasil diundang');
        return redirect()->back();
    }

    public function kick($id)
    {
        KelasMahasiswa::find($id)->delete();
        Alert::success('Berhasil', 'Mahasiswa berhasil dikeluarkan');
        return redirect()->back();
    }
}
