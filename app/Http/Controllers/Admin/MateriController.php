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
        $data = [
            'title' => 'Materi Management',
            'menu' => 'materi',
            'sub_menu' => 'materi',
            'materi' => Materi::find($id),
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
