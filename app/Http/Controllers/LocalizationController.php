<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
     //set session locale
     public function setlocate($locale){
        if (! in_array($locale, ['en', 'my'])) {
                    abort(400);
                }

        session(['localization' => $locale]);
        return back();
    }
}
