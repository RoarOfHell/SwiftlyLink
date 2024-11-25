<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        if (in_array($lang, ['en', 'ru'])) {
            App::setLocale($lang);
            session(['locale' => $lang]);
        }

        return json_encode(['message' => 'seccess']);
    }
}
