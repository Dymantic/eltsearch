<?php

namespace App\Http\Controllers\Admin\Schools;

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

        $purchase = $school->completePurchase($response, $package, auth()->user());

        return $purchase->toArray();

    }
}
