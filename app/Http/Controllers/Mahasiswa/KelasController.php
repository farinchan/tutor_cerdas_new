<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = KelasMahasiswa::where('nim', Auth::user()->mahasiswa->nim)->with('kelas');
        $data = [
            'title' => 'Kelas',
            'kode_kelas_new' => Str::random(10),
            'kelas' => $kelas->get()->pluck('kelas'),
        ];
        // dd($data);
        return view('pages.mahasiswa.kelas.index', $data);
    }

    public function show($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen', 'materi'])->first();
        $data = [
            'title' => 'Detail Kelas',
            'menu' => 'kelas',
            'sub_menu' => 'kelas',
            'kelas' => $kelas,
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'nilai_saya' => Mahasiswa::leftJoin('users', 'mahasiswa.user_id', 'users.id')
                ->leftJoin('kelas_mahasiswa', 'mahasiswa.nim', 'kelas_mahasiswa.nim')
                ->leftJoin('nilai', 'mahasiswa.nim', 'nilai.nim')
                ->where('kelas_mahasiswa.kode_kelas', $kode_kelas)
                ->where('mahasiswa.nim', Auth::user()->mahasiswa->nim)
                ->first(['mahasiswa.nim', 'users.name', 'nilai.nilai_tugas', 'nilai.nilai_quiz', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir'])

        ];
        // return response()->json($data);
        return view('pages.mahasiswa.kelas.show', $data);
    }
}
