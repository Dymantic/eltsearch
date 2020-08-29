<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Locations\Country;
use App\Rules\NonEmptyTranslation;
use App\Rules\UniqueTranslation;
use App\Translation;
use Illuminate\Http\Request;

class CountriesController extends Controller
{

    public function index()
    {
        return Country::with('regions.areas')->get()->map->toArray();
    }


    public function store()
    {
        request()->validate([
            'name' => [new NonEmptyTranslation, new UniqueTranslation('countries', 'name')],
        ]);

        Country::new(new Translation(request('name')));
    }

    public function update(Country $country)
    {
        request()->validate([
            'name' => [new NonEmptyTranslation, new UniqueTranslation('countries', 'name', $country->id)],
        ]);

        $country->rename(new Translation(request('name')));
    }

    public function delete(Country $country)
    {
        $country->fullDelete();
    }
}
