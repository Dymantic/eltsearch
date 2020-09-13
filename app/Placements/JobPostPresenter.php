<?php


namespace App\Placements;


use App\DateFormatter;
use Illuminate\Support\Facades\Lang;

class JobPostPresenter
{

    public static function forPublic(JobPost $post): array
    {
        $post->load('area.region.country', 'school');

        return [
            'slug'             => $post->slug,
            'school'           => $post->school->name,
            'school_name'      => $post->school_name,
            'area'             => $post->area->fullName('en'),
            'position'         => $post->position,
            'description'      => $post->description,
            'student_ages'     => self::group($post->student_ages, 'student_ages'),
            'requirements'     => self::group($post->requirements, 'requirements'),
            'benefits'         => self::group($post->benefits, 'benefits'),
            'schedule'         => self::group($post->schedule, 'schedule'),
            'work_on_weekends' => $post->works_on_weekends ? 'Yes' : 'No',
            'salary'           => self::salary($post->salary_min, $post->salary_max, $post->salary_rate),
            'students_min'     => $post->min_students,
            'students_max'     => $post->max_students,
            'contract'         => self::lang("contract.{$post->contract_length}"),
            'engagement'       => self::lang("engagement.{$post->engagement}"),
            'hours_per_week'   => $post->hours_per_week,
            'start_date'       => DateFormatter::pretty($post->start_date, 'As soon as possible'),
            'first_published'  => DateFormatter::standard($post->first_published_at),
            'expires_on'       => DateFormatter::standard($post->first_published_at ? $post->first_published_at->addDays(30) : null),
        ];
    }

    private static function salary($min, $max, $rate)
    {
        $range = $min === $max ? sprintf("NT$%s", $min) : sprintf("NT$%s - NT$%s", $min, $max);

        return sprintf("%s/%s", $range, Lang::get('job_posts.salary.' . $rate));
    }

    private static function group($items, $lang_key)
    {
        return collect($items)
            ->map(fn($item) => Lang::get("job_posts.{$lang_key}.{$item}", [], 'en'));
    }

    private static function lang($key)
    {
        return Lang::get("job_posts.{$key}", [], 'en');
    }
}
