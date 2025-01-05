<?php

namespace App\Http\Controllers;

use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Setting Website',
            'menu' => 'Setting',
            'sub_menu' => 'Website',
            'setting' => SettingWebsite::first(),
            'user' => Auth::user(),

        ];
        return view('pages.admin.setting.index', $data);
    }
}
