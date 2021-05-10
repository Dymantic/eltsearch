<?php

namespace App\Http\Controllers;

use App\Purchasing\Purchase;
use Illuminate\Http\Request;

class CancelledSecure3DSPurchaseController extends Controller
{
    public function store(Purchase $purchase)
    {
        $purchase->cancelled3DSFlow();

        return redirect("/schools/#purchases");
    }
}
