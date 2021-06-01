<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryPolicyController extends Controller
{
    public function show()
    {
        if(app()->getLocale() === 'zh') {
            return view('front.policies.delivery_zh');
        }
        return view('front.policies.delivery_en');
    }
}
