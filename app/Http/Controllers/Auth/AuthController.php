<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email' => ':attribute harus berupa email'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }else{
            Alert::error('Error', 'Email atau password salah');
            return redirect()->back();
        }
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerProcess(Request $request)
    {
        // dd($request->all());

        if ($request->role == 'mahasiswa') {

            $validator_mhs = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|in:mahasiswa,dosen',
                'nim' => 'required|numeric|unique:mahasiswa,nim',
                'nama' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'alamat' => 'required|string',
                'jenis_kelamin' => 'required|in:L,P',
                'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
                'jurusan' => 'required|string'
            ], [
                'required' => ':attribute tidak boleh kosong',
                'numeric' => ':attribute harus berupa angka',
                'string' => ':attribute harus berupa huruf',
                'image' => ':attribute harus berupa gambar',
                'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
                'max' => ':attribute tidak boleh lebih dari 2MB',
                'in' => ':attribute harus salah satu dari :values',
                'email' => ':attribute harus berupa email',
                'unique' => ':attribute sudah terdaftar',
            ]);


            if ($validator_mhs->fails()) {
                Alert::error('Error', $validator_mhs->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator_mhs);
            }



            $user = new User();
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $user->photo = $file->storeAs('foto', $filename, 'public');
            }
            $user->save();

            $user->assignRole('mahasiswa');

            $user->mahasiswa()->create([
                'nim' => $request->nim,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'jurusan' => $request->jurusan
            ]);

            Alert::success('Success', 'Registrasi berhasil silahkan login untuk melanjutkan');
            return redirect()->route('login');
        } else if ($request->role == 'dosen') {


            $validator_dosen = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|in:mahasiswa,dosen',
                'nidn' => 'required|numeric|unique:dosen,nidn',
                'nama' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'alamat' => 'required|string',
                'jenis_kelamin' => 'required|in:L,P',
                'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
                'jabatan' => 'required|string',
                'pangkat' => 'nullable|string',
                'pendidikan_terakhir' => 'required|string'
            ], [
                'required' => ':attribute tidak boleh kosong',
                'numeric' => ':attribute harus berupa angka',
                'string' => ':attribute harus berupa huruf',
                'image' => ':attribute harus berupa gambar',
                'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
                'max' => ':attribute tidak boleh lebih dari 2MB',
                'in' => ':attribute harus salah satu dari :values',
                'email' => ':attribute harus berupa email',
                'unique' => ':attribute sudah terdaftar',
            ]);

            if ($validator_dosen->fails()) {
                Alert::error('Error', $validator_dosen->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator_dosen);
            }

            $user = new User();
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $user->photo = $file->storeAs('foto', $filename, 'public');
            }
            $user->save();

            $user->assignRole('dosen');


            $user->dosen()->create([
                'nidn' => $request->nidn,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'pendidikan_terakhir' => $request->pendidikan_terakhir
            ]);

            Alert::success('Success', 'Registrasi berhasil, silahkan login untuk melanjutkan');
            return redirect()->route('login');
        } else if ($request->role == 'umum') {
            $validator_umum = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|in:umum',
                'nama' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'alamat' => 'required|string',
                'jenis_kelamin' => 'required|in:L,P',
                'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            ], [
                'required' => ':attribute tidak boleh kosong',
                'numeric' => ':attribute harus berupa angka',
                'string' => ':attribute harus berupa huruf',
                'image' => ':attribute harus berupa gambar',
                'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
                'max' => ':attribute tidak boleh lebih dari 2MB',
                'in' => ':attribute harus salah satu dari :values',
                'email' => ':attribute harus berupa email',
                'unique' => ':attribute sudah terdaftar',
            ]);

            if ($validator_umum->fails()) {
                Alert::error('Error', $validator_umum->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator_umum);
            }

            $user = new User();
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $user->photo = $file->storeAs('foto', $filename, 'public');
            }
            $user->save();

            $user->assignRole('umum');

            $user->umum()->create([
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
            ]);

            Alert::success('Success', 'Registrasi berhasil, silahkan login untuk melanjutkan');
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
