<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('nidn', Auth::user()->dosen->nidn)->with(['matakuliah', 'dosen', 'mahasiswa', 'materi']);
        $data = [
            'title' => 'Kelas',
            'kode_kelas_new' => Str::random(10),
            'kelas' => $kelas->get()
        ];
        return view('pages.dosen.kelas.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matakuliah' => 'required',
            'sks' => 'required|numeric',
            'kode_kelas' => 'required',
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan' => 'required',
        ], [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back();
        }

        $matakuliah = new Matakuliah();
        $matakuliah->nama_mk = $request->matakuliah;
        $matakuliah->sks = $request->sks;
        $matakuliah->save();

        $matakuliah = Matakuliah::where('nama_mk', $request->matakuliah)->first();
        Kelas::create([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'kode_mk' => $matakuliah->kode_mk,
            'nidn' => Auth::user()->dosen->nidn
        ]);

        Alert::success('Berhasil', 'Kelas berhasil ditambahkan');
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
            'list_mahasiswa_nonaktif' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'nonaktif')->get(),
            'mahasiswa_nonaktif_count' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->where('status', 'nonaktif')->count(),
            'list_nilai_mahasiswa' => Mahasiswa::leftJoin('users', 'mahasiswa.user_id', 'users.id')
                ->leftJoin('kelas_mahasiswa', 'mahasiswa.nim', 'kelas_mahasiswa.nim')
                ->leftJoin('nilai', 'mahasiswa.nim', 'nilai.nim')
                ->where('kelas_mahasiswa.kode_kelas', $kode_kelas)
                ->get(['mahasiswa.nim', 'users.name', 'nilai.nilai_tugas', 'nilai.nilai_quiz', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir'])

        ];
        // return response()->json($data);
        return view('pages.dosen.kelas.show', $data);
    }

    public function update($kode_kelas)
    {
        $validator = Validator::make(request()->all(), [
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan' => 'required',
        ], [
            'required' => ':attribute tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        Kelas::where('kode_kelas', $kode_kelas)->update([
            'nama_kelas' => request()->nama_kelas,
            'tingkat' => request()->tingkat,
            'jurusan' => request()->jurusan
        ]);

        Alert::success('Berhasil', 'Kelas berhasil diupdate');
        return redirect()->back();
    }

    public function delete($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();
        Storage::delete($kelas->matakuliah->file);
        $kelas->delete();
        Alert::success('Berhasil', 'Kelas berhasil dihapus');
        return redirect()->back();
    }

    

    public function UpdateNilai(Request $request, $kode_kelas)
    {
        $validator = Validator::make($request->all(), [
            'nilai_tugas' => 'nullable|numeric',
            'nilai_quiz' => 'nullable|numeric',
            'nilai_uts' => 'nullable|numeric',
            'nilai_uas' => 'nullable|numeric',
        ], [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $nilai_akhir = ($request->nilai_tugas ?? 0 + $request->nilai_quiz?? 0 + $request->nilai_uts?? 0 + $request->nilai_uas?? 0) / 4;

        Nilai::updateOrCreate(
            ['kode_kelas' => $kode_kelas, 'nim' => $request->nim],
            [
                'nilai_tugas' => $request->nilai_tugas,
                'nilai_quiz' => $request->nilai_quiz,
                'nilai_uts' => $request->nilai_uts,
                'nilai_uas' => $request->nilai_uas,
                'nilai_akhir' => $nilai_akhir
            ]
        );

        Alert::success('Berhasil', 'Nilai berhasil diupdate');
        return redirect()->back();
    }
}
