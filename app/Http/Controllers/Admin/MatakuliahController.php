<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MatakuliahController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Matakuliah Management',
            'menu' => 'matakuliah',
            'sub_menu' => 'matakuliah',
            'list_matakuliah' => Matakuliah::all()
        ];

        return view('pages.admin.matakuliah.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk' => 'required|unique:matakuliah,kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
        ], [
            'kode_mk.required' => 'Kode matakuliah wajib diisi',
            'kode_mk.unique' => 'Kode matakuliah sudah digunakan',
            'nama_mk.required' => 'Nama matakuliah wajib diisi',
            'sks.required' => 'SKS wajib diisi',
            'sks.numeric' => 'SKS harus berupa angka',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Matakuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
        ]);

        Alert::success('Success', 'Matakuliah berhasil ditambahkan');
        return redirect()->route('admin.matakuliah.index');

    }

    public function update(Request $request, $kode_mk)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk' => 'required|unique:matakuliah,kode_mk,' . $kode_mk . ',kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
        ], [
            'kode_mk.required' => 'Kode matakuliah wajib diisi',
            'kode_mk.unique' => 'Kode matakuliah sudah digunakan',
            'nama_mk.required' => 'Nama matakuliah wajib diisi',
            'sks.required' => 'SKS wajib diisi',
            'sks.numeric' => 'SKS harus berupa angka',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $matakuliah = Matakuliah::find($kode_mk);
        $matakuliah->update([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
        ]);

        Alert::success('Success', 'Matakuliah berhasil diubah');
        return redirect()->route('admin.matakuliah.index');
    }

    public function destroy($id)
    {
        $matakuliah = Matakuliah::find($id);
        $matakuliah->delete();

        Alert::success('Success', 'Matakuliah berhasil dihapus');
        return redirect()->route('admin.matakuliah.index');
    }
}
