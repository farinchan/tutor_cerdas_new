<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = KelasMahasiswa::where('nim', Auth::user()->mahasiswa->nim)->where('status', 'aktif')->with('kelas')->get();
        $data = [
            'title' => 'Kelas',
            'kode_kelas_new' => Str::random(10),
            'kelas' => Kelas::whereIn('kode_kelas', $kelas->pluck('kode_kelas'))->with([
                'pretest.session' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
                'matakuliah',
                'dosen'
            ])->get(),
        ];
        // dd($data);
        // return response()->json($data);
        return view('pages.mahasiswa.kelas.index', $data);
    }

    public function join()
    {
        $kelas = Kelas::where('kode_kelas', request()->kode_kelas)->first();
        if (!$kelas) {
            Alert::error('Error', 'kelas tidak ditemukan');
            return redirect()->back()->with('error', 'Kode kelas tidak ditemukan');
        }

        KelasMahasiswa::create([
            'nim' => Auth::user()->mahasiswa->nim,
            'kode_kelas' => $kelas->kode_kelas,
            'status' => 'nonaktif'
        ]);

        Alert::success('Berhasil', 'Permintaan bergabung berhasil dikirim, silahkan tunggu konfirmasi dari dosen, cek email secara berkala');
        return redirect()->back();
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
                ->first(['mahasiswa.nim', 'users.name', 'nilai.nilai_pretest', 'nilai.nilai_tugas', 'nilai.nilai_quiz', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir'])

        ];
        // return response()->json($data);
        return view('pages.mahasiswa.kelas.show', $data);
    }
}
