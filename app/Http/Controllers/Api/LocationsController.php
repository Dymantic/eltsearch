<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Locations\Country;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function index()
    {
        $lang = request('lang', 'en');
        return Country::with('regions.areas')->get()->map->presentForLang($lang);
    }
}
