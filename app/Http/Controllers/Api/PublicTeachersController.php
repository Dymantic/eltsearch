<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Teachers\Teacher;
use Illuminate\Http\Request;

class PublicTeachersController extends Controller
{
    public function index()
    {
        return Teacher::complete()->get();
    }
}
