<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\SettingWebsite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Profile Saya',
            'menu' => 'profile',
            'setting' => SettingWebsite::first(),
            'user' => Auth::user(),

        ];
        return view('pages.profile', $data);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $validation_rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($user->hasRole('mahasiswa')) {
            $validation_rules['nim'] = 'required|unique:mahasiswa,nim,' . ($user->mahasiswa->nim ?? '') . ',nim';
            $validation_rules['alamat_mahasiswa'] = 'required';
            $validation_rules['jenis_kelamin_mahasiswa'] = 'required';
            $validation_rules['agama_mahasiswa'] = 'required';
            $validation_rules['jurusan'] = 'required';
        }

        if ($user->hasRole('dosen')) {
            $validation_rules['nidn'] = 'required|unique:dosen,nidn,' . ($user->dosen->nidn ?? '') . ',nidn';
            $validation_rules['jabatan'] = 'required';
            $validation_rules['pangkat'] = 'required';
            $validation_rules['alamat_dosen'] = 'required';
            $validation_rules['jenis_kelamin_dosen'] = 'required';
            $validation_rules['agama_dosen'] = 'required';
            $validation_rules['pendidikan_terakhir'] = 'required';
        }

        $validator = Validator::make($request->all(), $validation_rules, [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah terdaftar',
            'email' => 'format email tidak valid',
            'min' => ':attribute minimal :min karakter',
            'image' => ':attribute harus berupa gambar',
            'mimes' => 'format gambar tidak valid',
            'max' => 'ukuran gambar maksimal :max KB'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_path = $photo->storeAs('photos', date('YmdHis') . '-' . Str::slug($request->name) . '.' . $photo->getClientOriginalExtension(), 'public');
            $user->photo = str_replace('public/', '', $photo_path);
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        if ($user->hasRole('mahasiswa')) {
            if (!$user->mahasiswa) {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $request->nim,
                    'alamat' => $request->alamat_mahasiswa,
                    'jenis_kelamin' => $request->jenis_kelamin_mahasiswa,
                    'agama' => $request->agama_mahasiswa,
                    'jurusan' => $request->jurusan,
                ]);
            }
            Mahasiswa::where('user_id', $user->id)->update([
                'nim' => $request->nim,
                'alamat' => $request->alamat_mahasiswa,
                'jenis_kelamin' => $request->jenis_kelamin_mahasiswa,
                'agama' => $request->agama_mahasiswa,
                'jurusan' => $request->jurusan,
            ]);
        }

        if ($user->hasRole('dosen')) {
            if (!$user->dosen) {
                Dosen::create([
                    'user_id' => $user->id,
                    'nidn' => $request->nidn,
                    'jabatan' => $request->jabatan,
                    'pangkat' => $request->pangkat,
                    'alamat' => $request->alamat_dosen,
                    'jenis_kelamin' => $request->jenis_kelamin_dosen,
                    'agama' => $request->agama_dosen,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                ]);
            }
            Dosen::where('user_id', $user->id)->update([
                'nidn' => $request->nidn,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'alamat' => $request->alamat_dosen,
                'jenis_kelamin' => $request->jenis_kelamin_dosen,
                'agama' => $request->agama_dosen,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
            ]);
        }

        Alert::success('Berhasil', 'Profile berhasil diupdate');
        return redirect()->back();
    }
}
