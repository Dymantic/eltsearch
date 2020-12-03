<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Purchasing\Purchase;
use App\Purchasing\PurchasePresenter;
use Illuminate\Http\Request;

class PurchasesOverviewController extends Controller
{
    public function show()
    {
        $this_month = Purchase::paid()->since(now()->startOfMonth());

        return [
            'total_this_month'        => $this_month->count(),
            'total_revenue_for_month' => sprintf("$%.0f", $this_month->sum('price') / 100),
            'recent'                  => Purchase::with('customer')
                                                 ->paid()
                                                 ->latest()
                                                 ->limit(30)
                                                 ->get()
                                                 ->map(fn($p) => PurchasePresenter::forAdmin($p))
                                                 ->values()->all(),
        ];
    }
}
