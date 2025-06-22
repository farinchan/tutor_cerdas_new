<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'list_dosen' => User::role('dosen')->inRandomOrder()->limit(8)->get(),
            'dosen_count' => User::role('dosen')->count(),
            'mahasiswa_count' => User::role('mahasiswa')->count(),
            'umum_count' => User::role('umum')->count(),
        ];
        return view('pages.home', $data);
    }
}
