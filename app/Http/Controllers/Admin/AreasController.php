<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Locations\Area;
use App\Locations\Region;
use App\Rules\NonEmptyTranslation;
use App\Rules\UniqueInRegion;
use App\Translation;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function store(Region $region)
    {
        request()->validate([
            'name' => [new NonEmptyTranslation(), new UniqueInRegion($region)]
        ]);

        $region->addArea(new Translation(request('name')));
    }

    public function update(Area $area)
    {
        request()->validate([
            'name' => [new NonEmptyTranslation(), new UniqueInRegion($area->region, $area->id)]
        ]);

        $area->rename(new Translation(request('name')));
    }

    public function delete(Area $area)
    {
        $area->delete();
    }
}
