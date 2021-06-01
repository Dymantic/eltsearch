<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefundPolicyController extends Controller
{
    public function show()
    {
        if(app()->getLocale() === 'zh') {
            return view('front.policies.refund_zh');
        }
        return view('front.policies.refund_en');
    }
}
