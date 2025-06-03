<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
     public function index()
    {
        $data = [
            'title' => 'Kelas',
            'kode_kelas_new' => Str::random(10),
            'kelas' => Kelas::with([
                'pretest.session' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
                'matakuliah',
                'dosen'
            ])->get(),
        ];
        // dd($data);
        // return response()->json($data);
        return view('pages.umum.kelas.index', $data);
    }

    public function show($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen'])->first();
        $data = [
            'title' => 'Detail Kelas',
            'menu' => 'kelas',
            'sub_menu' => 'kelas',
            'kelas' => $kelas,
            'materi_list' => Materi::where('kode_kelas', $kode_kelas)->with([
                'exam.examSessions' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ])->get()
                ->map(function ($materi, $index) use ($kode_kelas) {
                    // Cek apakah ada ujian terkait dengan materi ini
                    $materi->is_locked = false; // Default terbuka

                    if ($index > 0) {
                        $materi_sebelumnya = Materi::where('kode_kelas', $kode_kelas)
                            ->with(['exam.examSessions' => function ($query) {
                                $query->where('user_id', Auth::id());
                            }])
                            ->orderBy('id', 'asc')
                            ->get()[$index - 1];

                        $examSession = $materi_sebelumnya->exam?->examSessions?->contains('status', 'lulus') ?? false;

                        if (!$examSession) {
                            $materi->is_locked = true; // Kunci materi jika ujian sebelumnya belum lulus
                        }
                    }

                    return $materi;
                }),
            // 'nilai_saya' => Mahasiswa::leftJoin('users', 'mahasiswa.user_id', 'users.id')
            //     ->leftJoin('kelas_mahasiswa', 'mahasiswa.nim', 'kelas_mahasiswa.nim')
            //     ->leftJoin('nilai', 'mahasiswa.nim', 'nilai.nim')
            //     ->where('kelas_mahasiswa.kode_kelas', $kode_kelas)
            //     ->where('mahasiswa.nim', Auth::user()->mahasiswa->nim)
            //     ->first(['mahasiswa.nim', 'users.name', 'nilai.nilai_pretest', 'nilai.nilai_tugas', 'nilai.nilai_quiz', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir'])

        ];
        // return response()->json($data);
        return view('pages.umum.kelas.show', $data);
    }
}
