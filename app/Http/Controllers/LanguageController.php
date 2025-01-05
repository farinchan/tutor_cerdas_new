<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {

        $language = in_array($locale, ['en', 'id']) ? $locale : 'en';
        if ($language) {
            App::setLocale($language);
            session(['locale' => $language]);
        }

        Log::info("Locale set to: " . $language . " (Selected language: " . $language . ")");


        if ($language == 'id') {
            Alert::success('Berhasil', 'Bahasa telah diubah ke Bahasa Indonesia');
        } else {
            Alert::success('Success', 'Language has been changed to English');
        }
        return redirect()->back();
    }
}
