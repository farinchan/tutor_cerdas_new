<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;

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
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
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


            try {
                $user->assignRole('mahasiswa');
                $user->mahasiswa()->create([
                    'nim' => $request->nim,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                    'jurusan' => $request->jurusan
                ]);
            } catch (\Exception $e) {
                // Jika terjadi error, hapus user yang sudah dibuat
                $user->delete();
                Alert::error('Error', 'Terjadi kesalahan saat menyimpan data mahasiswa. Silahkan coba lagi.');
                return redirect()->back()->withInput();
            }


            Alert::success('Success', 'Registrasi berhasil silahkan login untuk melanjutkan');
            return redirect()->route('login');
        } else if ($request->role == 'dosen') {


            $validator_dosen = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|in:mahasiswa,dosen',
                'nidn' => 'required|numeric|unique:dosen,nidn',
                'nama' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
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

            try {
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
            } catch (\Exception $e) {
                // Jika terjadi error, hapus user yang sudah dibuat
                $user->delete();
                Alert::error('Error', 'Terjadi kesalahan saat menyimpan data dosen. Silahkan coba lagi.');
                return redirect()->back()->withInput();
            }



            Alert::success('Success', 'Registrasi berhasil, silahkan login untuk melanjutkan');
            return redirect()->route('login');
        } else if ($request->role == 'umum') {
            $validator_umum = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|in:umum',
                'nama' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
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

            try {
                $user->assignRole('umum');
                $user->umum()->create([
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                ]);
            } catch (\Exception $e) {
                // Jika terjadi error, hapus user yang sudah dibuat
                $user->delete();
                Alert::error('Error', 'Terjadi kesalahan saat menyimpan data umum. Silahkan coba lagi.');
                return redirect()->back()->withInput();
            }

            Alert::success('Success', 'Registrasi berhasil, silahkan login untuk melanjutkan');
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    public function forgotPasswordProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email' => ':attribute harus berupa email',
            'exists' => ':attribute tidak terdaftar dalam sistem'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Delete old tokens for this email
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Generate new token
        $token = Str::random(64);

        // Store token in database
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Send email
        try {
            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));
            Alert::success('Success', 'Link reset password telah dikirim ke email Anda');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal mengirim email. Silahkan coba lagi.');
            return redirect()->back();
        }

        return redirect()->route('login');
    }

    public function resetPassword($token)
    {
        return view('pages.auth.reset-password', ['token' => $token]);
    }

    public function resetPasswordProcess(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email' => ':attribute harus berupa email',
            'exists' => ':attribute tidak terdaftar dalam sistem',
            'min' => ':attribute minimal :min karakter',
            'confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Check if token exists and is valid
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            Alert::error('Error', 'Token reset password tidak valid');
            return redirect()->route('forgot.password');
        }

        // Verify token
        if (!Hash::check($token, $resetRecord->token)) {
            Alert::error('Error', 'Token reset password tidak valid');
            return redirect()->route('forgot.password');
        }

        // Check if token is expired (60 minutes)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 60) {
            Alert::error('Error', 'Token reset password telah kadaluarsa');
            return redirect()->route('forgot.password');
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        Alert::success('Success', 'Password berhasil direset. Silahkan login dengan password baru');
        return redirect()->route('login');
    }
}
