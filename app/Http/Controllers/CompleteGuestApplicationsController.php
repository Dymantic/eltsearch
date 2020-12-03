<?php

namespace App\Http\Controllers;

use App\Placements\GuestApplication;
use Illuminate\Http\Request;

class CompleteGuestApplicationsController extends Controller
{
    public function store()
    {
        GuestApplication::complete();

        auth()->login(GuestApplication::teacherProfile()->user);
        return redirect("/teachers#/applications");
    }
}
