<?php

namespace App\Http\Controllers\Umum;

use App\Events\DiskusiPribadiCreated;
use App\Http\Controllers\Controller;
use App\Models\DiskusiPribadi;
use App\Models\Exam;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MateriController extends Controller
{
    public function materiDiskusiPribadi($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Materi',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'list_diskusi_pribadi' => DiskusiPribadi::where('user_chat_id', Auth::user()->id)->where('materi_id', $id)->orderBy('created_at', 'asc')->with('user')->get(),
            'exam' => Exam::where('materi_id', $id)->with([
                'examSessions' => function ($query) {
                    $query->where('user_id', Auth::user()->id);
                }
            ])->first()
        ];
        // return response()->json($data);
        return view('pages.umum.materi.diskusi-pribadi', $data);
    }

    public function historyUjian($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with(['kelas', 'exam'])->first();
        $data = [
            'title' => 'Materi',
            'menu' => 'kelas',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,

            'exam' => Exam::where('materi_id', $id)->with([
                'examSessions' => function ($query) {
                    $query->where('user_id', Auth::user()->id)->orderBy('id', 'desc');
                }
            ])->first()
        ];
        // return response()->json($data);
        return view('pages.umum.materi.exam-history', $data);
    }
}
