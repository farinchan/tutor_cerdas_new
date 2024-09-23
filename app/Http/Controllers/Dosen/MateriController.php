<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use App\Models\KelasMahasiswa;
use App\Models\DiskusiGrup;
use App\Events\DiskusiGrupCreated;
use App\Models\DiskusiPribadi;
use App\Events\DiskusiPribadiCreated;
use App\Models\MateriFile;

class MateriController extends Controller
{
    public function create($kode_kelas)
    {
        if (Kelas::where('kode_kelas', $kode_kelas)->count() == 0) {
            return abort(404);
        }

        $data = [
            'title' => 'Buat Materi',
            'menu' => 'materi',
            'sub_menu' => 'create',
            'kode_kelas' => $kode_kelas,
            'kelas' => Kelas::where('kode_kelas', $kode_kelas)->first()
        ];
        return view('pages.dosen.materi.create', $data);
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());
        if (Kelas::where('kode_kelas', $request->kode_kelas)->count() == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'foto' => 'nullable',
            'judul' => 'required',
            'deskripsi' => 'required',
            'isi_materi' => 'required',
            'file' => 'nullable',
            'kode_kelas' => 'required',
            'status' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }

        $fotoPath = null;
        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            $fotoNewName = Str::random(10) . "_" . $foto->getClientOriginalName();
            $fotoPath = $foto->storeAs('public/materi/foto', $fotoNewName);
        }

        $materi = Materi::create([
            'gambar' => $fotoPath,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'isi_materi' => $request->isi_materi,
            'gambar' => $fotoPath,
            'nidn' => Auth::user()->dosen->nidn,
            'kode_kelas' => $request->kode_kelas,
            'status' => $request->status
        ]);

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {

                $fileNewName = Str::random(10) . "_" . $file->getClientOriginalName();
                $filePath = $file->storeAs('materi', $fileNewName, 'public');
                MateriFile::create([
                    'materi_id' => $materi->id,
                    'file' => str_replace('public/', '', $filePath)
                ]);
            }
        }   

        return response()->json([
            'status' => 'success',
            'message' => 'Materi berhasil ditambahkan',
            'redirect' => route('dosen.kelas.show', $request->kode_kelas)
        ]);
    }

    public function uploadFile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|array',
        ], [
            'required' => ':attribute tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $file->storeAs('public/materi', Str::random(10) . "_" . $file->getClientOriginalName());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'File berhasil diupload'
            ]);
        }
    }

    public function materi($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Materi',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'list_diskusi_grup' => DiskusiGrup::where('materi_id', $id)->orderBy('created_at', 'asc')->with('user')->get()
        ];
        // return response()->json($data);
        return view('pages.dosen.materi.show', $data);
    }

    public function kirimDiskusiGrup(Request $request, $materi_id)
    {
        $diskusi_grup = DiskusiGrup::create([
            'materi_id' => $materi_id,
            'user_id' =>  Auth::user()->id,
            'pesan' => $request->pesan
        ]);

        Broadcast(new DiskusiGrupCreated(
            $diskusi_grup->load('user')
        ))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim',
            'data' => $diskusi_grup->load('user')
        ]);
    }

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
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'list_diskusi_pribadi' => DiskusiPribadi::where('materi_id', $id)->orderBy('created_at', 'asc')->with('user')->get()
        ];
        // return response()->json($data);
        return view('pages.dosen.materi.diskusi-pribadi', $data);
    }

    public function kirimDiskusiPribadi(Request $request, $materi_id)
    {
        $diskusi_pribadi = DiskusiPribadi::create([
            'materi_id' => $materi_id,
            'user_id' =>  Auth::user()->id,
            'pesan' => $request->pesan
        ]);

        Broadcast(new DiskusiPribadiCreated(
            $diskusi_pribadi->load('user')
        ))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim',
            'data' => $diskusi_pribadi->load('user')
        ]);
    }
}
