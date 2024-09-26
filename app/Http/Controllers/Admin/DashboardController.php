<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'menu' => 'dashboard',
            'sub_menu' => 'dashboard',
            'matakuliah_count' => Matakuliah::count(),
            'kelas_count' => Kelas::count(),
            'materi_count' => Materi::count(),
            'user_count' => User::count(),
        ];

        return view('pages.admin.dashboard.index', $data);
    }

    public function stat(){
        $data = [
            'user_register' => User::select(DB::raw('Date(created_at) as date'), DB::raw('count(*) as total'))
            ->limit(30)
            ->groupBy('date')
            ->get(),
        ];

        return response()->json($data);
    }
}
