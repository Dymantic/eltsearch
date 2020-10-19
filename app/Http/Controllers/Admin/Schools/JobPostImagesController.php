<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JobPostImagesController extends Controller
{
    public function store(JobPost $post)
    {
        request()->validate([
            'image' => ['required', 'image']
        ]);

        if($post->hasMaxImages()) {
            throw ValidationException::withMessages([
                'image' => 'you have already used up all your allowed images for this post'
            ]);
        }

        $post->addImage(request('image'));
    }

    public function destroy(JobPost $post, Media $image)
    {
        $image->delete();
    }
}
