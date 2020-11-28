<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Nation;
use Illuminate\Http\Request;

class NationsController extends Controller
{
    public function index()
    {
        return Nation::all();
    }
}
