<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Purchasing\PurchasePresenter;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolPurchasesController extends Controller
{
    public function index(School $school)
    {
        return $school
            ->purchases()
            ->latest()
            ->get()
            ->map(fn($p) => PurchasePresenter::forAdmin($p));
    }
}
