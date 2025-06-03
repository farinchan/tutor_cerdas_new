<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Pretest;
use App\Models\PretestAnswer;
use App\Models\PretestChoice;
use App\Models\PretestQuestion;
use App\Models\PretestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PretestController extends Controller
{
    public function pretest($kode_kelas)
    {
        $kelas = Kelas::with(['matakuliah', 'dosen', 'materi'])->where('kode_kelas', $kode_kelas)->first();
        // dd($kelas);

        if (!$kelas) {
            return abort(404);
        }
        $session = PretestSession::where('user_id', Auth::id())->where('pretest_id', $kelas->pretest->id)->first();
        $session_id =  null;
        if ($session) {
            if ($session->end_time) {
                return redirect()->route('umum.kelas.index')->with('error', 'Pretest sudah selesai');
            }
            $session_id = $session->id;
        } else {
            $session_new = new PretestSession();
            $session_new->user_id = Auth::id();
            $session_new->pretest_id = $kelas->pretest->id;
            $session_new->start_time = now();
            $session_new->save();
            $session_id = $session_new->id;
        }

        $pretest = PretestQuestion::where('pretest_id', $kelas->pretest->id)->with([
            'choices',
            'userAnswer' => function ($query) use ($session_id) {
                $query->where('pretest_session_id', $session_id);
            }
        ])->get()->shuffle();

        $data = [
            'title' => 'Pretest',
            'menu' => 'kelas',
            'kode_kelas' => $kode_kelas,
            'session_id' => $session_id,
            'sub_menu' => $kode_kelas->nama_kelas ?? 'Pretest Kelas',
            'pretest' => $kelas->pretest,
            'session' => $session,
            'random_pretest' => $pretest->pluck('id')->toArray(),
            // 'question_last_id' => $pretest->last()->id,
            'question' => PretestQuestion::where('pretest_id', $kelas->pretest->id)->where('id', $pretest->first()->id)->with([
                'choices',
                'userAnswer' => function ($query) use ($session_id) {
                    $query->where('pretest_session_id', $session_id);
                }
            ])->first(),
            'question_list' => $pretest,
        ];
        // return response()->json($data);
        return view('pages.umum.kelas.pretest', $data);
    }

    public function pretestSoal(Request $request)
    {
        $session_id = $request->session_id;
        $question_id = $request->question_id;
        $random_pretest = $request->random_pretest;

        $data = [
            'question_id' => $question_id,
            'question' => PretestQuestion::where('id', $question_id)->with([
                'choices',
                'userAnswer' => function ($query) use ($session_id) {
                    $query->where('pretest_session_id', $session_id);
                }
            ])->first(),
            'question_list' => PretestQuestion::with('choices')->wherein('id', $random_pretest)
                ->orderByRaw('FIELD(id, ' . implode(',', $random_pretest) . ')')
                ->with([
                    'choices',
                    'userAnswer' => function ($query) use ($session_id) {
                        $query->where('pretest_session_id', $session_id);
                    }
                ])->get(),

        ];
        return response()->json($data);
    }

    public function pretestJawab(Request $request)
    {
        $session_id = $request->session_id;
        $question_id = $request->question_id;
        $choice_id = $request->choice_id;

        $session = PretestSession::find($session_id);
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $question = PretestQuestion::find($question_id);
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $choice = $question->choices->where('id', $choice_id)->first();
        if (!$choice) {
            return response()->json(['error' => 'Choice not found'], 404);
        }
        $answer_correct = null;
        $choice_true = PretestChoice::where('pretest_question_id', $question_id)->where('is_correct', 1)->first(); // get true choice
        if ($choice_true->id == $choice_id) {
            $answer_correct = true;
        } else {
            $answer_correct = false;
        }

        $answer = $session->answers->where('pretest_question_id', $question_id)->first();
        if ($answer) {
            $answer->pretest_choice_id = $choice_id;
            $answer->is_correct = $answer_correct;
            $answer->save();
        } else {
            $answer_new = new PretestAnswer();
            $answer_new->pretest_session_id = $session_id;
            $answer_new->pretest_question_id = $question_id;
            $answer_new->pretest_choice_id = $choice_id;
            $answer_new->is_correct = $answer_correct;
            $answer_new->save();
        }

        return response()->json(['message' => 'Answer saved']);
    }

    public function pretestSelesai(Request $request, $kode_kelas)
    {
        $session_id = $request->session_id;
        $session = PretestSession::find($session_id);
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $score = PretestAnswer::where('pretest_session_id', $session_id)->where('is_correct', 1)->join('pretest_question', 'pretest_question.id', '=', 'pretest_answer.pretest_question_id')->sum('score');

        $session->end_time = now();
        $session->score = $score;
        $session->save();

        return redirect()->route('umum.kelas.show', $kode_kelas)->with('success', 'Pretest selesai');
    }
}
