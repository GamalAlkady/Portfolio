<?php

namespace App\Http\Controllers\Admin;

use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;

class LanguageController
{

    public function index()
    {
        return view('admin.language.index');
    }
    public function switch(Request $request)
    {
        $locale = $request->getParam('locale'); 
        if (in_array($locale, config('app', 'available_locales'))) {
            // die('ok');
            session()->set('locale', $locale);
        }
        
        return back();
    }
}