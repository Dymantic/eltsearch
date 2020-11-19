<?php


namespace App\Placements;


use App\DateFormatter;
use App\Schools\School;
use Illuminate\Support\Facades\Lang;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JobPostPresenter
{

    public static function forPublic(JobPost $post): array
    {
        $post->load('area.region.country', 'school');
        $logo = $post->school->getFirstMedia(School::LOGOS);

        return [
            'slug'               => $post->slug,
            'school'             => $post->school->name,
            'school_name'        => $post->school_name,
            'area'               => $post->area->fullName('en'),
            'position'           => $post->position,
            'description'        => $post->description,
            'student_ages'       => self::group($post->student_ages, 'student_ages'),
            'requirements'       => self::group($post->requirements, 'requirements'),
            'benefits'           => self::group($post->benefits, 'benefits'),
            'schedule'           => self::group($post->schedule, 'schedule'),
            'work_on_weekends'   => $post->works_on_weekends ? 'Yes' : 'No',
            'salary'             => self::salary($post->salary_min, $post->salary_max, $post->salary_rate),
            'students_min'       => $post->min_students,
            'students_max'       => $post->max_students,
            'contract'           => trans("job_posts.contract.{$post->contract_length}", [], "en"),
            'engagement'         => trans("job_posts.engagement.{$post->engagement}", [], "en"),
            'hours_per_week'     => $post->hours_per_week,
            'start_date'         => DateFormatter::pretty($post->start_date, 'As soon as possible'),
            'first_published'    => DateFormatter::standard($post->first_published_at),
            'has_been_published' => !!$post->first_Published_at,
            'expires_on'         => DateFormatter::standard($post->first_published_at ? $post->first_published_at->addDays(30) : null),
            'originally_created' => DateFormatter::PRETTY($post->created_at),
            'logo'               => [
                'thumb'    => optional($logo)->getUrl('thumb'),
                'original' => optional($logo)->getUrl(),
            ],
            'images'             => $post->getMedia(JobPost::IMAGES)->map(
                fn(Media $media) => [
                    'id'       => $media->id,
                    'thumb'    => $media->getUrl('thumb'),
                    'original' => $media->getUrl(),
                ]
            )->values()->all(),
        ];
    }

    public static function forAdmin(JobPost $post): array
    {
        $post->load('area.region.country', 'school');
        $logo = $post->school->getFirstMedia(School::LOGOS);
        $lang = app()->getLocale();

        return [
            'id'                    => $post->id,
            'status'                => $post->status('en'),
            'slug'                  => $post->slug,
            'school'                => $post->school->name,
            'school_name'           => $post->school_name,
            'area'                  => optional($post->area)->fullName($lang),
            'position'              => $post->position,
            'description'           => $post->description,
            'student_ages'          => self::group($post->student_ages, 'student_ages', $lang),
            'requirements'          => self::group($post->requirements, 'requirements', $lang),
            'benefits'              => self::group($post->benefits, 'benefits', $lang),
            'schedule'              => self::group($post->schedule, 'schedule', $lang),
            'work_on_weekends'      => $post->works_on_weekends ? 'Yes' : 'No',
            'salary'                => self::salary($post->salary_min, $post->salary_max, $post->salary_rate),
            'students_min'          => $post->min_students,
            'students_max'          => $post->max_students,
            'contract'              => trans("job_posts.contract.{$post->contract_length}", [], $lang),
            'engagement'            => trans("job_posts.engagement.{$post->engagement}", [], $lang),
            'hours_per_week'        => $post->hours_per_week,
            'start_date'            => DateFormatter::pretty($post->start_date, 'As soon as possible'),
            'first_published'       => DateFormatter::standard($post->first_published_at),
            'has_been_published'    => !!$post->first_published_at,
            'expires_on'            => DateFormatter::standard($post->first_published_at ? $post->first_published_at->addDays(30) : null),
            'originally_created'    => DateFormatter::PRETTY($post->created_at),
            'ready_for_publication' => $post->readyForPublication(),
            'required_fields'       => self::presentRequiredFields($post),
            'logo'                  => [
                'thumb'    => optional($logo)->getUrl('thumb'),
                'original' => optional($logo)->getUrl(),
            ],
            'images'                => $post->getMedia(JobPost::IMAGES)->map(
                fn(Media $media) => [
                    'id'       => $media->id,
                    'thumb'    => $media->getUrl('thumb'),
                    'original' => $media->getUrl(),
                ]
            )->values()->all(),
        ];
    }

    private static function presentRequiredFields(JobPost $post)
    {
        return collect($post->requiredFieldsStatus())
            ->map(function ($field) {
                return ['label' => trans($field['label']), 'complete' => $field['complete']];
            })->values()->toArray();
    }


    private static function salary($min, $max, $rate)
    {
        $range = $min === $max ? sprintf("NT$%s", $min) : sprintf("NT$%s - NT$%s", $min, $max);

        return sprintf("%s/%s", $range, Lang::get('job_posts.salary.' . $rate));
    }

    private static function group($items, $lang_key, $locale = 'en')
    {
        return collect($items)
            ->map(fn($item) => trans("job_posts.{$lang_key}.{$item}", [], $locale));
    }

    private static function lang($key)
    {
        return Lang::get("job_posts.{$key}", [], 'en');
    }
}
