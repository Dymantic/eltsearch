<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchasesQueryRequest;
use App\PagedData;
use App\Purchasing\Purchase;
use App\Purchasing\PurchasePresenter;
use App\Schools\School;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function index(PurchasesQueryRequest $request)
    {
        $page = Purchase::with('customer')
                        ->select('purchases.*')
                        ->join(
                            'schools',
                            fn($join) => $join->on('schools.id', '=',
                                'purchases.customer_id')->where('purchases.customer_type', School::class)
                        )
                        ->where('purchases.gateway_ref_no', 'LIKE', "%{$request->search()}%")
                        ->orWhere('purchases.ref_no', 'LIKE', "%{$request->search()}%")
                        ->orderBy($request->order(), $request->direction())
                        ->paginate(50);

        return PagedData::forPage($page, fn($p) => PurchasePresenter::forAdmin($p));
    }

    public function show(Purchase $purchase)
    {
        return PurchasePresenter::forAdmin($purchase);
    }
}
