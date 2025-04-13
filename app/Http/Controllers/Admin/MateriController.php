<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MateriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Materi Management',
            'menu' => 'materi',
            'sub_menu' => 'materi',
            'list_materi' => Materi::all(),
        ];

        return view('pages.admin.materi.index', $data);
    }

    public function show($id)
    {
        $materi = Materi::find($id);
        $data = [
            'title' => 'Materi Management',
            'menu' => 'materi',
            'sub_menu' => 'materi',
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
                })->get()
        ];

        return view('pages.admin.materi.show', $data);
    }

    public function destroy($id)
    {
        Materi::destroy($id);

        Alert::success('Success', 'Materi berhasil dihapus');
        return redirect()->route('admin.materi.index');
    }
}
