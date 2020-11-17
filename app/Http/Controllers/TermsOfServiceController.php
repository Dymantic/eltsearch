<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsOfServiceController extends Controller
{
    public function show()
    {
        if(app()->getLocale() === 'zh') {
            return view('front.policies.terms_of_service_zh');
        }

        return view('front.policies.terms_of_service_en');
    }
}
