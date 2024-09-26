<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelas Management',
            'menu' => 'kelas',
            'sub_menu' => 'kelas',
            'kode_kelas_new' => Str::random(10),
            'list_kelas' => Kelas::all(),
            'list_matakuliah' => Matakuliah::all(),
            'list_dosen' => User::withRole('dosen')->with('dosen')->get(),
        ];
        // dd($data);
        return view('pages.admin.kelas.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan' => 'required',
            'kode_mk' => 'required',
            'nidn' => 'required',
        ], [
            'kode_kelas.required' => 'Kode kelas wajib diisi',
            'kode_kelas.unique' => 'Kode kelas sudah digunakan',
            'nama_kelas.required' => 'Nama kelas wajib diisi',
            'kode_mk.required' => 'Matakuliah wajib diisi',
            'nidn.required' => 'Dosen wajib diisi',
            'tingkat.required' => 'Tingkat wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Kelas::create([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'kode_mk' => $request->kode_mk,
            'nidn' => $request->nidn,
        ]);

        Alert::success('Success', 'Kelas berhasil ditambahkan');
        return redirect()->route('admin.kelas.index');

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required',
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan' => 'required',
            'kode_mk' => 'required',
            'nidn' => 'required',
        ], [
            'kode_kelas.required' => 'Kode kelas wajib diisi',
            'kode_kelas.unique' => 'Kode kelas sudah digunakan',
            'nama_kelas.required' => 'Nama kelas wajib diisi',
            'kode_mk.required' => 'Matakuliah wajib diisi',
            'nidn.required' => 'Dosen wajib diisi',
            'tingkat.required' => 'Tingkat wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Kelas::find($id)->update([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'kode_mk' => $request->kode_mk,
            'nidn' => $request->nidn,
        ]);

        Alert::success('Success', 'Kelas berhasil diupdate');
        return redirect()->route('admin.kelas.index');
    }

    public function destroy($id)
    {
        Kelas::find($id)->delete();

        Alert::success('Success', 'Kelas berhasil dihapus');
        return redirect()->route('admin.kelas.index');
    }

}
