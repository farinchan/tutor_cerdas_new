<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'User Management',
            'menu' => 'user',
            'sub_menu' => 'user',
            'users' => User::all()
        ];

        return view('pages.admin.user.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create User',
            'menu' => 'user',
            'sub_menu' => 'user'
        ];

        return view('pages.admin.user.create', $data);
    }

    public function store(Request $request)
    {

        if ($request->role_mahasiswa == null && $request->role_dosen == null && $request->role_admin == null) {
            Alert::warning('Warning', 'Pilih role terlebih dahulu');
            return redirect()->back();
        }

        // dd($request->all());

        $validation_rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->role_mahasiswa) {
            $validation_rules['nim'] = 'required|unique:mahasiswa,nim';
            $validation_rules['alamat_mahasiswa'] = 'required';
            $validation_rules['jenis_kelamin_mahasiswa'] = 'required';
            $validation_rules['agama_mahasiswa'] = 'required';
            $validation_rules['jurusan'] = 'required';
        }

        if ($request->role_dosen) {
            $validation_rules['nidn'] = 'required|unique:dosen,nidn';
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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_path = $photo->storeAs('photos', date('YmdHis') . '-' . Str::slug($request->name) . '.' . $photo->getClientOriginalExtension(), 'public');
            $user->photo = str_replace('public/', '', $photo_path);
        }
        $user->save();

        if ($request->role_mahasiswa) {
            $user->assignRole('mahasiswa');
            $user->mahasiswa()->create([
                'nim' => $request->nim,
                'alamat' => $request->alamat_mahasiswa,
                'jenis_kelamin' => $request->jenis_kelamin_mahasiswa,
                'agama' => $request->agama_mahasiswa,
                'jurusan' => $request->jurusan
            ]);
        }

        if ($request->role_dosen) {
            $user->assignRole('dosen');
            $user->dosen()->create([
                'nidn' => $request->nidn,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'alamat' => $request->alamat_dosen,
                'jenis_kelamin' => $request->jenis_kelamin_dosen,
                'agama' => $request->agama_dosen,
                'pendidikan_terakhir' => $request->pendidikan_terakhir
            ]);
        }

        if ($request->role_admin) {
            $user->assignRole('admin');
        }

        Alert::success('Success', 'User berhasil ditambahkan');
        return redirect()->route('admin.user.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'title' => 'Edit User',
            'menu' => 'user',
            'sub_menu' => 'user',
            'user' => $user
        ];

        return view('pages.admin.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validation_rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($user->hasRole('mahasiswa')) {
            $validation_rules['nim'] = 'required|unique:mahasiswa,nim,' . $user->mahasiswa->nim. ',nim';
            $validation_rules['alamat_mahasiswa'] = 'required';
            $validation_rules['jenis_kelamin_mahasiswa'] = 'required';
            $validation_rules['agama_mahasiswa'] = 'required';
            $validation_rules['jurusan'] = 'required';
        }

        if ($user->hasRole('dosen')) {
            $validation_rules['nidn'] = 'required|unique:dosen,nidn,' . $user->dosen->nidn . ',nidn';
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
            $user->assignRole('mahasiswa');
            Mahasiswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $request->nim,
                    'alamat' => $request->alamat_mahasiswa,
                    'jenis_kelamin' => $request->jenis_kelamin_mahasiswa,
                    'agama' => $request->agama_mahasiswa,
                    'jurusan' => $request->jurusan
                ]
            );
        } else {
            $user->removeRole('mahasiswa');
        }

        if ($user->hasRole('dosen')) {
            Dosen::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nidn' => $request->nidn,
                    'jabatan' => $request->jabatan,
                    'pangkat' => $request->pangkat,
                    'alamat' => $request->alamat_dosen,
                    'jenis_kelamin' => $request->jenis_kelamin_dosen,
                    'agama' => $request->agama_dosen,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir
                ]
            );
        } else {
            $user->removeRole('dosen');
        }

        if ($request->role_admin) {
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
        }

        Alert::success('Success', 'User berhasil diupdate');
        return redirect()->route('admin.user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('mahasiswa')) {
            $user->mahasiswa()->delete();
        }

        if ($user->hasRole('dosen')) {
            $user->dosen()->delete();
        }

        $user->delete();

        Alert::success('Success', 'User berhasil dihapus');
        return redirect()->route('admin.user.index');
    }
}
