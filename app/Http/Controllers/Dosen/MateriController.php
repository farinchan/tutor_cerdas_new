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
use App\Models\Exam;
use App\Models\ExamChoice;
use App\Models\ExamQuestion;
use App\Models\MateriFile;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;


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
        if ($request->hasFile('foto')) {
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

    public function materiDiskusiPribadi($kode_kelas, $id, ?string $chat_id = null)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Materi',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'chat_id' => $chat_id ? $chat_id : 0,
            'materi' => $materi,
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'list_diskusi_pribadi' => $chat_id ? DiskusiPribadi::where('user_chat_id', $chat_id)->where('materi_id', $id)->orderBy('created_at', 'asc')->with('user')->get() : null,
        ];
        // return response()->json($data);
        return view('pages.dosen.materi.diskusi-pribadi', $data);
    }

    public function kirimDiskusiPribadi(Request $request, $materi_id, $chat_id)
    {
        $diskusi_pribadi = DiskusiPribadi::create([
            'materi_id' => $materi_id,
            'user_id' =>  Auth::user()->id,
            'pesan' => $request->pesan,
            'user_chat_id' => $chat_id
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

    public function ujianSoal($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Soal Ujian',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'exam' => $materi->exam,
            'list_exam_question' => $materi?->exam?->id ? ExamQuestion::where('exam_id', $materi->exam->id)->get() : []
        ];
        // return response()->json($data);
        return view('pages.dosen.materi.ujian-soal', $data);
    }

    public function ujianSoalStore(Request $request, $kode_kelas, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'duration' => 'required|numeric',
            'minimum_score' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back();
        }

        $exam = Exam::create([
            'materi_id' => $id,
            'description' => $request->description,
            'duration' => $request->duration,
            'minimum_score' => $request->minimum_score,
        ]);

        Alert::success('Berhasil', 'ujian berhasil dibuat');
        return redirect()->back();
    }

    public function ujianSoalUpdate(Request $request, $kode_kelas, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'duration' => 'required|numeric',
            'minimum_score' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back();
        }

        $exam = Exam::where('materi_id', $id)->first();
        $exam->update([
            'description' => $request->description,
            'duration' => $request->duration,
            'minimum_score' => $request->minimum_score,
        ]);

        Alert::success('Berhasil', 'ujian berhasil diupdate');
        return redirect()->back();
    }

    public function ujianSoalQuestionCreate($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Soal Ujian',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'exam' => $materi->exam,
        ];

        return view('pages.dosen.materi.ujian-soal-create', $data);
    }

    public function ujianSoalQuestionStore(Request $request, $kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();

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

        $question = ExamQuestion::create([
            'exam_id' => $materi->exam->id,
            'question' => $request->question_text,
            'score' => $request->question_score
        ]);

        foreach ($request->choices as $index => $choice) {
            ExamChoice::create([
                'exam_question_id' => $question->id,
                'choice_text' => $choice['choice_text'] ?? "",
                'choice_image' => isset($choice['choice_image']) && is_file($choice['choice_image'])
                    ? $choice['choice_image']->storeAs('exam/choice', Str::random(16) . '.' . $choice['choice_image']->getClientOriginalExtension(), 'public')
                    : null,
                'is_correct' => $index == $request->is_correct ? 1 : 0, // Bandingkan dengan is_correct dari request
            ]);
        }

        Alert::success('Berhasil', 'Soal berhasil ditambahkan');
        return redirect()->route('dosen.kelas.materi.ujianSoal', [$kode_kelas, $id]);
    }

    public function ujianSoalQuestionEdit($kode_kelas, $id, $question_id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $question = ExamQuestion::where('id', $question_id)->where('exam_id', $materi->exam->id)->with('examChoices')->first();
        $data = [
            'title' => 'Soal Ujian',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'exam' => $materi->exam,
            'question' => $question,
        ];

        // return response()->json($data);
        return view('pages.dosen.materi.ujian-soal-edit', $data);
    }

    public function ujianSoalQuestionUpdate(Request $request, $kode_kelas, $id, $question_id)
    {
        // dd($request->all());
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $question = ExamQuestion::where('id', $question_id)->where('exam_id', $materi->exam->id)->first();

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
                    ExamChoice::where('id', $choice['id'])->delete();
                }
                continue;
            }

            // Jika item baru (belum ada id), maka buat item baru
            if (!isset($choice['id'])) {
                ExamChoice::create([
                    'exam_question_id' => $question->id,
                    'choice_text' => $choice['choice_text'],
                    'choice_image' => isset($choice['choice_image']) && is_file($choice['choice_image'])
                        ? $choice['choice_image']->storeAs('exam/choice', Str::random(16) . '.' . $choice['choice_image']->getClientOriginalExtension(), 'public')
                        : null,
                    'is_correct' => $index == $request->is_correct ? 1 : 0,
                ]);
            } else {
                // Update item yang ada
                $multipleChoice = ExamChoice::find($choice['id']);
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
        return redirect()->route('dosen.kelas.materi.ujianSoal', [$kode_kelas, $id]);
    }

    public function ujianSoalQuestionDelete($kode_kelas, $id, $question_id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $question = ExamQuestion::where('id', $question_id)->where('exam_id', $materi->exam->id)->first();
        $question->examChoices()->delete();
        $question->delete();

        Alert::success('Berhasil', 'Soal berhasil dihapus');
        return redirect()->route('dosen.kelas.materi.ujianSoal', [$kode_kelas, $id]);
    }

    public function ujianNilai($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with('kelas')->first();
        $data = [
            'title' => 'Nilai Ujian',
            'menu' => 'kelas',
            'sub_menu' => 'materi',
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'materi' => $materi,
            'exam_mahasiswa' => User::whereHas('roles', function ($query) {
                $query->where('name', 'mahasiswa');
            })
                ->with([
                    'mahasiswa',
                    'examSessions' => function ($query) use ($materi) {
                        $query->where(
                            'exam_id',
                            $materi->exam->id
                        )->latest();
                    }
                ])
                ->whereHas('examSessions.exam', function ($query) use ($materi) {
                    $query->where('materi_id', $materi->id);
                })->get(),
            'exam_umum' => User::whereHas('roles', function ($query) {
                $query->where('name', 'umum');
            })
                ->with([
                    'examSessions' => function ($query) use ($materi) {
                        $query->where(
                            'exam_id',
                            $materi->exam->id
                        )->latest();
                    }
                ])
                ->whereHas('examSessions.exam', function ($query) use ($materi) {
                    $query->where('materi_id', $materi->id);
                })->get(),
        ];
        // return response()->json($data);
        return view('pages.dosen.materi.ujian-nilai', $data);
    }
}
