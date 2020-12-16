<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolTokensController extends Controller
{
    public function index(School $school)
    {
        return $school->availableTokens->map->toArray();
    }
}
