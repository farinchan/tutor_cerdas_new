<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
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
}
