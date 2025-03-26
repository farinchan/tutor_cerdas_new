<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamChoice;
use App\Models\ExamQuestion;
use App\Models\ExamSession;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function exam($kode_kelas, $id)
    {
        $materi = Materi::where('id', $id)->where('kode_kelas', $kode_kelas)->with(['kelas', 'exam'])->first();
        if (!$materi) {
            return redirect()->route('mahasiswa.kelas.index')->with('error', 'Materi tidak ditemukan');
        }


        $session = ExamSession::where('user_id', Auth::id())->where('exam_id', $materi->exam->id)->latest()->first();
        $session_id =  null;

        if ($session) {
            if ($session->end_time == null && $session->status == null) {
                $session->delete();

                $session_new = new ExamSession();
                $session_new->user_id = Auth::id();
                $session_new->exam_id = $materi->exam->id;
                $session_new->start_time = now();
                $session_new->save();

                $session_id = $session_new->id;
            } else {
                $session_new = new ExamSession();
                $session_new->user_id = Auth::id();
                $session_new->exam_id = $materi->exam->id;
                $session_new->start_time = now();
                $session_new->save();

                $session_id = $session_new->id;
            }
        } else {
            $session_new = new ExamSession();
            $session_new->user_id = Auth::id();
            $session_new->exam_id = $materi->exam->id;
            $session_new->start_time = now();
            $session_new->save();

            $session_id = $session_new->id;
        }

        $examQuestion = ExamQuestion::where('exam_id', $materi->exam->id)->with([
            'examChoices',
            'examAnswers' => function ($query) use ($session_id) {
                $query->where('exam_session_id', $session_id);
            }
        ])->get()->shuffle();

        $data = [
            'title' => 'Ujian Materi ' . $materi->judul,
            'menu' => 'kelas',
            'sub_menu' => "",
            'kode_kelas' => $kode_kelas,
            'materi_id' => $id,
            'session_id' => $session_id,
            'exam' => $materi->exam,
            'session' => $session,
            'sub_menu' => $kode_kelas->nama_kelas ?? 'exam Kelas',
            'random_exam' => $examQuestion->pluck('id')->toArray(),
            // 'question_last_id' => $exam->last()->id,
            'question' => ExamQuestion::where('exam_id', $materi->exam->id)->where('id', $examQuestion->first()->id)->with([
                'examChoices',
                'examAnswers' => function ($query) use ($session_id) {
                    $query->where('exam_session_id', $session_id);
                }
            ])->first(),
            'question_list' => $examQuestion,
        ];
        // return response()->json($data);
        return view('pages.mahasiswa.materi.exam', $data);
    }

    public function examSoal(Request $request)
    {
        $session_id = $request->session_id;
        $question_id = $request->question_id;
        $random_exam = $request->random_exam;

        $data = [
            'question_id' => $question_id,
            'question' => ExamQuestion::where('id', $question_id)->with([
                'examChoices',
                'examAnswers' => function ($query) use ($session_id) {
                    $query->where('exam_session_id', $session_id);
                }
            ])->first(),
            'question_list' => ExamQuestion::with('examChoices')->wherein('id', $random_exam)
                ->orderByRaw('FIELD(id, ' . implode(',', $random_exam) . ')')
                ->with([
                    'examChoices',
                    'examAnswers' => function ($query) use ($session_id) {
                        $query->where('exam_session_id', $session_id);
                    }
                ])->get(),

        ];
        return response()->json($data);
    }

    public function examJawab(Request $request)
    {
        $session_id = $request->session_id;
        $question_id = $request->question_id;
        $choice_id = $request->choice_id;

        $session = ExamSession::find($session_id);
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $question = ExamQuestion::find($question_id);
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $choice = $question->ExamChoices->where('id', $choice_id)->first();
        if (!$choice) {
            return response()->json(['error' => 'Choice not found'], 404);
        }
        $answer_correct = null;
        $choice_true = ExamChoice::where('exam_question_id', $question_id)->where('is_correct', 1)->first(); // get true choice
        if ($choice_true->id == $choice_id) {
            $answer_correct = true;
        } else {
            $answer_correct = false;
        }

        $answer = $session->examAnswers->where('exam_question_id', $question_id)->first();
        if ($answer) {
            $answer->exam_choice_id = $choice_id;
            $answer->is_correct = $answer_correct;
            $answer->save();
        } else {
            $answer_new = new ExamAnswer();
            $answer_new->exam_session_id = $session_id;
            $answer_new->exam_question_id = $question_id;
            $answer_new->exam_choice_id = $choice_id;
            $answer_new->is_correct = $answer_correct;
            $answer_new->save();
        }

        return response()->json(['message' => 'Answer saved']);
    }

    public function examSelesai(Request $request, $kode_kelas, $id)
    {
        $session_id = $request->session_id;
        $session = ExamSession::find($session_id);
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $score = ExamAnswer::where('exam_session_id', $session_id)->where('is_correct', 1)->join('exam_question', 'exam_question.id', '=', 'exam_answer.exam_question_id')->sum('score');
        $exam = Exam::where('materi_id', $id)->first();

        $session->end_time = now();
        $session->score = $score;
        $session->status = $score >= $exam->minimum_score ? 'lulus' : 'tidak lulus';
        $session->save();

        return redirect()->route('mahasiswa.kelas.materi', [$kode_kelas, $id])->with('success', 'exam selesai');
    }
}
