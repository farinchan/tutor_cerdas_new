<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use App\Models\Pretest;
use App\Models\PretestChoice;
use App\Models\PretestQuestion;
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
            'title' => 'Daftar Kelas',
            'menu' => 'kelas',
            'kode_kelas_new' => Str::random(10),
            'kelas' => $kelas->get(),
            'list_kelas' => Kelas::all(),
            'list_matakuliah' => Matakuliah::all(),
        ];
        // dd($data);
        return view('pages.dosen.kelas.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'jurusan' => 'required',
            'kode_mk' => 'required',
        ], [
            'kode_kelas.required' => 'Kode kelas wajib diisi',
            'kode_kelas.unique' => 'Kode kelas sudah digunakan',
            'nama_kelas.required' => 'Nama kelas wajib diisi',
            'kode_mk.required' => 'Matakuliah wajib diisi',
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
            'nidn' => Auth::user()->dosen->nidn
        ]);

        Alert::success('Success', 'Kelas berhasil ditambahkan');
        return redirect()->back();
    }
    public function show($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen', 'materi'])->first();
        $data = [
            'title' => "Kelas " . $kelas->nama_kelas,
            'menu' => 'kelas',
            'kelas' => $kelas,
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'list_mahasiswa_nonaktif' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'nonaktif')->get(),
            'mahasiswa_nonaktif_count' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'nonaktif')->count(),
            'list_nilai_mahasiswa' => Mahasiswa::leftJoin('users', 'mahasiswa.user_id', 'users.id')
                ->leftJoin('kelas_mahasiswa', 'mahasiswa.nim', 'kelas_mahasiswa.nim')
                ->leftJoin('nilai', 'mahasiswa.nim', 'nilai.nim')
                ->where('kelas_mahasiswa.kode_kelas', $kode_kelas)
                ->orderBy('mahasiswa.nim')
                ->get(['mahasiswa.nim', 'users.name','nilai.nilai_pretest', 'nilai.nilai_tugas', 'nilai.nilai_quiz', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir']),
            'exam' => $kelas->pretest,
            'list_exam_question' => $kelas?->pretest?->id ? PretestQuestion::where('pretest_id', $kelas?->pretest?->id)->get() : []

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

        $nilai_akhir = ($request->nilai_tugas ?? 0 + $request->nilai_quiz ?? 0 + $request->nilai_uts ?? 0 + $request->nilai_uas ?? 0) / 4;

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

    public function pretestCreate(Request $request, $kode_kelas){
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'duration' => 'required|numeric',
        ], [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ]);

        if ($validator->fails()) {
            Alert::error('Failed', $validator->errors()->all());
            return redirect()->back();
        }

        $exam = Pretest::updateOrCreate(
            ['kode_kelas' => $kode_kelas],
            [
                'description' => $request->description,
                'duration' => $request->duration,
            ]
        );


        Alert::success('Success', 'Pretest berhasil dibuat');
        return redirect()->back();
    }
    public function pretestQuestionCreate($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with('materi')->first();
        $data = [
            'title' => 'Pretest Soal',
            'menu' => 'kelas',
            'sub_menu' => 'Pretest',
            'kode_kelas' => $kode_kelas,
        ];

        return view('pages.dosen.kelas.partials.pretest-soal-create', $data);
    }

    public function pretestQuestionStore(Request $request, $kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with('materi')->first();
        if (!$kelas) {
            Alert::error('Gagal', 'Kelas tidak ditemukan');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'question_text' => 'required',
            'question_score' => 'required|numeric',
            'choices' => 'required|array|min:2',
            'choices.*.choice_text' => 'nullable',
            'choices.*.choice_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_correct' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
            'min' => 'Pilihan jawaban minimal 2'
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back();
        }

        $question = PretestQuestion::create([
            'pretest_id' => $kelas->pretest->id,
            'question' => $request->question_text,
            'score' => $request->question_score
        ]);

        foreach ($request->choices as $index => $choice) {
            PretestChoice::create([
                'pretest_question_id' => $question->id,
                'choice_text' => $choice['choice_text'] ?? "",
                'choice_image' => isset($choice['choice_image']) && is_file($choice['choice_image'])
                    ? $choice['choice_image']->storeAs('exam/choice', Str::random(16) . '.' . $choice['choice_image']->getClientOriginalExtension(), 'public')
                    : null,
                'is_correct' => $index == $request->is_correct ? 1 : 0, // Bandingkan dengan is_correct dari request
            ]);
        }

        Alert::success('Berhasil', 'Soal berhasil ditambahkan');
        return redirect()->route('dosen.kelas.show', $kode_kelas);

    }

    public function pretestQuestionEdit($kode_kelas, $question_id)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with('materi')->first();
        $question = PretestQuestion::where('id', $question_id)->where('pretest_id', $kelas->pretest->id)->with('choices')->first();
        $data = [
            'title' => 'Soal Ujian',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'kelas' => $kelas,
            'exam' => $kelas->pretest,
            'question' => $question,
        ];

        // return response()->json($data);
        return view('pages.dosen.kelas.partials.pretest-soal-edit', $data);
    }

    public function pretestQuestionUpdate(Request $request, $kode_kelas, $question_id)
    {
        // dd($request->all());
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();
        $question = PretestQuestion::where('id', $question_id)->where('pretest_id', $kelas->pretest->id)->with('choices')->first();

        $validator = Validator::make($request->all(), [
            'question_text' => 'required',
            'question_score' => 'required|numeric',
            'choices' => 'required|array|min:2',
            'choices.*.choice_text' => 'nullable',
            'choices.*.choice_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_correct' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
            'min' => 'Pilihan jawaban minimal 2'
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back();
        }

        $question->update([
            'question' => $request->question_text,
            'score' => $request->question_score
        ]);


        // Update atau buat pilihan jawaban
        foreach ($request->choices as $index => $choice) {
            // Cek apakah pilihan ditandai sebagai dihapus
            if (isset($choice['is_deleted']) && $choice['is_deleted'] == '1') {
                if (isset($choice['id'])) {
                    // Jika item sudah ada di database, hapus
                    PretestChoice::where('id', $choice['id'])->delete();
                }
                continue;
            }

            // Jika item baru (belum ada id), maka buat item baru
            if (!isset($choice['id'])) {
                PretestChoice::create([
                    'pretest_question_id' => $question->id,
                    'choice_text' => $choice['choice_text'],
                    'choice_image' => isset($choice['choice_image']) && is_file($choice['choice_image'])
                        ? $choice['choice_image']->storeAs('exam/choice', Str::random(16) . '.' . $choice['choice_image']->getClientOriginalExtension(), 'public')
                        : null,
                    'is_correct' => $index == $request->is_correct ? 1 : 0,
                ]);
            } else {
                // Update item yang ada
                $multipleChoice = PretestChoice::find($choice['id']);
                $multipleChoice->update([
                    'choice_text' => $choice['choice_text'],
                    'choice_image' => isset($choice['choice_image']) && is_file($choice['choice_image'])
                        ? $choice['choice_image']->storeAs('exam/choice', Str::random(16) . '.' . $choice['choice_image']->getClientOriginalExtension(), 'public')
                        : $multipleChoice->choice_image,
                    'is_correct' => $index == $request->is_correct ? 1 : 0,
                ]);
            }
        }

        Alert::success('Berhasil', 'Soal berhasil diupdate');
        return redirect()->route('dosen.kelas.show', $kode_kelas);
    }


    public function pretestQuestionDelete($kode_kelas, $question_id)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with('materi')->first();
        $question = PretestQuestion::where('id', $question_id)->where('pretest_id', $kelas->pretest->id)->first();
        if ($question) {
            $question->choices()->delete();
            $question->delete();
        }

        Alert::success('Berhasil', 'Soal berhasil dihapus');
        return redirect()->route('dosen.kelas.show', $kode_kelas);
    }



}
