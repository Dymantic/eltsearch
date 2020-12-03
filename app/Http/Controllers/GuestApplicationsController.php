<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestApplicationRequest;
use App\Placements\GuestApplication;
use Illuminate\Http\Request;

class GuestApplicationsController extends Controller
{
    public function store(GuestApplicationRequest $request)
    {
        GuestApplication::storeInitialApplication($request->applicationInfo());

        return redirect('/guest-applications/create-profile');
    }
}
