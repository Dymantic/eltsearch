<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Purchasing\Package;
use App\Purchasing\Transaction;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolPurchasesController extends Controller
{

    public function index(School $school)
    {
        return $school->purchases()->with('user')->latest()->get()->map->toArray();
    }

    public function store(CheckoutRequest $request, School $school, Transaction $transaction)
    {
        $package = Package::find(request('package_id'));

        $response = $transaction
            ->for($school)
            ->withPaymentDetails($request->paymentDetails())
            ->buy($package);


        if($response->requiresSecure3D()) {
            $school->initiatePurchase($response, $package, auth()->user());
            return [
                'requires_secure3d_redirect' => true,
                'redirect_secure3d_url' => $response->secure3DRedirectUrl(),
            ];
        }

        $purchase = $school->completePurchase($response, $package, auth()->user());

        return $purchase->toArray();

    }
}
