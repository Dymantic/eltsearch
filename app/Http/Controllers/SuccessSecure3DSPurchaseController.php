<?php

namespace App\Http\Controllers;

use App\Purchasing\Purchase;
use Illuminate\Http\Request;

class SuccessSecure3DSPurchaseController extends Controller
{
    public function store(Purchase $purchase)
    {
        $purchase->complete3DSFlow();

        return redirect("/schools/#purchases");
    }
}
