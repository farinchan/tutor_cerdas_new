<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Mail\AcceptMahasiswaMail;
use App\Mail\InviteMahasiswaMail;
use App\Mail\KickMahasiswaMail;
use App\Mail\RegisterMail;
use App\Mail\RejectMahasiswaMail;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Mail;

class MahasiswaController extends Controller
{
    public function invite($kode_kelas)
    {
        $validator = Validator::make(request()->all(), [
            'nim' => 'required|exists:mahasiswa,nim',
        ], [
            'required' => ':attribute tidak boleh kosong',
            'exists' => 'Mahasiswa tidak ditemukan'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (KelasMahasiswa::where('kode_kelas', $kode_kelas)->where('nim', request()->nim)->exists()) {
            Alert::error('Error', 'Mahasiswa sudah terdaftar di kelas ini');
            return redirect()->back();
        }

        KelasMahasiswa::create([
            'kode_kelas' => $kode_kelas,
            'nim' => request()->nim,
            'status' => 'aktif'
        ]);

        $mahasiswa = Mahasiswa::where('nim', request()->nim)->join('users', 'mahasiswa.user_id', '=', 'users.id')->first();
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();
        Mail::to($mahasiswa->user->email)->send(new InviteMahasiswaMail([
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'kode_kelas' => $kelas->kode_kelas,
            'nama_kelas' => $kelas->nama_kelas,
            'matakuliah' => $kelas->matakuliah->nama_mk,
            'dosen' => $kelas->dosen->user->name,
        ]));


        Alert::success('Berhasil', 'Mahasiswa berhasil diundang');
        return redirect()->back();
    }

    public function accept($id)
    {
        $mahasiswa = Mahasiswa::where('nim', KelasMahasiswa::find($id)->nim)->join('users', 'mahasiswa.user_id', '=', 'users.id')->first();
        $kelas = Kelas::where('kode_kelas', KelasMahasiswa::find($id)->kode_kelas)->first();
        Mail::to($mahasiswa->user->email)->send(new AcceptMahasiswaMail([
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'kode_kelas' => $kelas->kode_kelas,
            'nama_kelas' => $kelas->nama_kelas,
            'matakuliah' => $kelas->matakuliah->nama_mk,
            'dosen' => $kelas->dosen->user->name,
        ]));

        KelasMahasiswa::find($id)->update(['status' => 'aktif']);
        Alert::success('Berhasil', 'Mahasiswa berhasil diterima');
        return redirect()->back();
    }

    public function reject($id)
    {
        $mahasiswa = Mahasiswa::where('nim', KelasMahasiswa::find($id)->nim)->join('users', 'mahasiswa.user_id', '=', 'users.id')->first();
        $kelas = Kelas::where('kode_kelas', KelasMahasiswa::find($id)->kode_kelas)->first();
        Mail::to($mahasiswa->user->email)->send(new RejectMahasiswaMail([
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'kode_kelas' => $kelas->kode_kelas,
            'nama_kelas' => $kelas->nama_kelas,
            'matakuliah' => $kelas->matakuliah->nama_mk,
            'dosen' => $kelas->dosen->user->name,
        ]));

        KelasMahasiswa::find($id)->delete();
        Alert::success('Berhasil', 'Mahasiswa berhasil ditolak');
        return redirect()->back();
    }

    public function kick($id)
    {
        $mahasiswa = Mahasiswa::where('nim', KelasMahasiswa::find($id)->nim)->join('users', 'mahasiswa.user_id', '=', 'users.id')->first();
        $kelas = Kelas::where('kode_kelas', KelasMahasiswa::find($id)->kode_kelas)->first();
        Mail::to($mahasiswa->user->email)->send(new KickMahasiswaMail([
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'kode_kelas' => $kelas->kode_kelas,
            'nama_kelas' => $kelas->nama_kelas,
            'matakuliah' => $kelas->matakuliah->nama_mk,
            'dosen' => $kelas->dosen->user->name,
        ]));

        KelasMahasiswa::find($id)->delete();
        Alert::success('Berhasil', 'Mahasiswa berhasil dikeluarkan');
        return redirect()->back();
    }


}
