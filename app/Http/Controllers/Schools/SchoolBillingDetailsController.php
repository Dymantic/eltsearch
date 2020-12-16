<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillingDetailsRequest;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolBillingDetailsController extends Controller
{
    public function update(BillingDetailsRequest $request, School $school)
    {
        $school->setBillingDetails($request->billingDetails());
    }
}
