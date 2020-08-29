<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\NonEmptyTranslation;
use App\Rules\UniqueTranslation;
use App\Schools\SchoolType;
use App\Translation;
use Illuminate\Http\Request;

class SchoolTypesController extends Controller
{

    public function index()
    {
        return SchoolType::all()->map(fn (SchoolType $type) => [
            'id' => $type->id,
            'name' => $type->name->toArray(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => [
                new NonEmptyTranslation(),
                new UniqueTranslation('school_types', 'name')
            ]
        ]);

        SchoolType::new(new Translation(request('name')));
    }

    public function update(SchoolType $schoolType)
    {
        request()->validate([
            'name' => [
                new NonEmptyTranslation(),
                new UniqueTranslation('school_types', 'name', $schoolType->id),
            ]
        ]);

        $schoolType->rename(new Translation(request('name')));
    }

    public function delete(SchoolType $schoolType)
    {
        $schoolType->delete();
    }
}
