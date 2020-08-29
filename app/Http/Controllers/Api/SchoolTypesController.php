<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Schools\SchoolType;
use Illuminate\Http\Request;

class SchoolTypesController extends Controller
{
    public function index()
    {
        $lang = request('lang', 'en');

        return SchoolType::all()->map->presentForLang($lang);
    }
}
