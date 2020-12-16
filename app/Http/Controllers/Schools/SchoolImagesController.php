<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SchoolImagesController extends Controller
{
    public function store(School $school)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        if ($school->hasMaxImages()) {
            throw ValidationException::withMessages(['image' => 'You have already used all your available images']);
        }

        $school->addImage(request('image'));
    }

    public function delete(School $school, Media $image)
    {
        if($image->model->is($school)) {
            $image->delete();
        }
    }
}
