<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolLogosController extends Controller
{
    public function store(School $school)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $school->setLogo(request('image'));
    }

    public function destroy(School $school)
    {
        $school->clearLogo();
    }
}
