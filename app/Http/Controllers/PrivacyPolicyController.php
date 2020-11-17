<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function show()
    {
        if(app()->getLocale() === 'zh') {
            return view('front.policies.privacy_zh');
        }

        return view('front.policies.privacy_en');
    }
}
