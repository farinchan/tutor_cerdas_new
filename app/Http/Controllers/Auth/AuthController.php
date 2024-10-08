<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

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
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:mahasiswa,dosen',
                'nim' => 'required|numeric',
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
                'email' => ':attribute harus berupa email'
            ]);


            if ($validator_mhs->fails()) {
                Alert::error('Error', $validator_mhs->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator_mhs);
            }

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $user->assignRole('mahasiswa');

            if ($request->hasFile('foto')) {
                $request->file('foto')->storeAs('public/foto', $request->nim . "-" . $request->nama . "." . $request->file('foto')->getClientOriginalExtension());
            }

            $user->mahasiswa()->create([
                'nim' => $request->nim,
                'foto' => $request->file('foto') ? $request->nim . "-" . $request->nama . "." . $request->file('foto')->getClientOriginalExtension() : null,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'jurusan' => $request->jurusan
            ]);

            Alert::success('Success', 'Registrasi berhasil silahkan login untuk melanjutkan');
            return redirect()->route('login');
        } else {


            $validator_dosen = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:mahasiswa,dosen',
                'nidn' => 'required|numeric',
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
                'email' => ':attribute harus berupa email'
            ]);

            if ($validator_dosen->fails()) {
                Alert::error('Error', $validator_dosen->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator_dosen);
            }


            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->assignRole('dosen');


            if ($request->hasFile('foto')) {
                $request->file('foto')->storeAs('public/foto', $request->nidn . "-" . $request->nama . "." . $request->file('foto')->getClientOriginalExtension());
            }

            $user->dosen()->create([
                'nidn' => $request->nidn,
                'foto' => $request->file('foto') ? $request->nidn . "-" . $request->nama . "." . $request->file('foto')->getClientOriginalExtension() : null,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'pendidikan_terakhir' => $request->pendidikan_terakhir
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
