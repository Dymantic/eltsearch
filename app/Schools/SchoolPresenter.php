<?php


namespace App\Schools;


use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SchoolPresenter
{
    public static function forAdmin(School $school)
    {
        $school->load('area', 'schoolTypes');
        $logo = $school->getFirstMedia(School::LOGOS);
        $images = $school->getMedia(School::IMAGES);

        return [
            'id'                 => $school->id,
            'name'               => $school->name,
            'introduction'       => $school->introduction,
            'area_id'            => $school->area_id,
            'location'           => optional($school->area)->fullName('en'),
            'school_types'       => $school->schoolTypes->map->toArray()->values()->all(),
            'billing_address'    => $school->billing_address,
            'billing_state'      => $school->billing_state,
            'billing_city'       => $school->billing_city,
            'billing_country'    => $school->billing_country,
            'billing_zip'        => $school->billing_zip,
            'school_types_names' => $school->schoolTypes->map(fn($type) => $type->name->in('en'))->values()->all(),
            'logo'               => [
                'thumb'    => optional($logo)->getUrl('thumb'),
                'original' => optional($logo)->getUrl(),
            ],
            'images'             => $images->map(
                fn(Media $media) => [
                    'id'       => $media->id,
                    'thumb'    => $media->getUrl('thumb'),
                    'original' => $media->getUrl(),
                ]
            )->values()->all(),
        ];
    }
}
