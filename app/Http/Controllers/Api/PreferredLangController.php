<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PreferredLangController extends Controller
{
    public function store()
    {
        request()->validate([
            'lang' => [Rule::in(['en', 'zh'])],
        ]);
        auth()->user()->setLanguagePreference(request('lang'));
    }
}
