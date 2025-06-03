<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{

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
