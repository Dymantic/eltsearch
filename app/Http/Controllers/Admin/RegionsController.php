<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Locations\Country;
use App\Locations\Region;
use App\Rules\NonEmptyTranslation;
use App\Rules\UniqueInCountry;
use App\Translation;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    public function store(Country $country)
    {
        request()->validate([
            'name' => [new NonEmptyTranslation(), new UniqueInCountry($country)]
        ]);

        $country->addRegion(new Translation(request('name')));
    }

    public function update(Region $region)
    {
        request()->validate([
            'name' => [new NonEmptyTranslation(), new UniqueInCountry($region->country, $region->id)]
        ]);

        $region->rename(new Translation(request('name')));
    }

    public function delete(Region $region)
    {
        $region->fullDelete();
    }
}
