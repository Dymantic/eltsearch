<?php


namespace App\Placements;


use App\Locations\Area;
use Illuminate\Support\Facades\Lang;

class JobSearchPresenter
{
    public static function forTeacher(JobSearch $search): array
    {
        return [
            'id' => $search->id,
            'area_ids' => $search->area_ids,
            'student_ages' => $search->student_ages,
            'benefits' => $search->benefits,
            'contract_type' => $search->contract_type,
            'salary' => $search->salary,
            'hours_per_week' => $search->hours_per_week,
            'weekends' => $search->weekends,
            'engagement' => $search->engagement,
            'schedule' => $search->schedule,
            'used_criteria' => $search->listCriteria(),
            'search_descriptions' => [
                [
                    'criteria' => 'locations',
                    'description' => self::describeLocations($search->area_ids),
                    'description_type' => 'list',
                    'included' => $search->hasLocation(),
                ],
                [
                    'criteria' => 'student ages',
                    'description' => self::describeStudentAges($search->student_ages),
                    'description_type' => 'list',
                    'included' => $search->hasStudentAges(),
                ],
                [
                    'criteria' => 'benefits',
                    'description' => self::describeBenefits($search->benefits),
                    'description_type' => 'list',
                    'included' => $search->hasBenefits(),
                ],
                [
                    'criteria' => 'contract types',
                    'description' => self::describeContractTypes($search->contract_type),
                    'description_type' => 'list',
                    'included' => $search->hasContractTypes(),
                ],
                [
                    'criteria' => 'working times',
                    'description' => self::describeSchedule($search->schedule),
                    'description_type' => 'list',
                    'included' => $search->hasSchedule(),
                ],
                [
                    'criteria' => 'salary',
                    'description' => self::describeSalary($search->salary),
                    'description_type' => 'string',
                    'included' => $search->hasSalary(),
                ],
                [
                    'criteria' => 'hours per week',
                    'description' => self::describeHours($search->hours_per_week),
                    'description_type' => 'string',
                    'included' => $search->hasHours(),
                ],
                [
                    'criteria' => 'weekend work',
                    'description' => self::describeWeekends($search->weekends),
                    'description_type' => 'string',
                    'included' => $search->hasWeekends(),
                ],
                [
                    'criteria' => 'part time or full time',
                    'description' => self::describeEngagement($search->engagement),
                    'description_type' => 'string',
                    'included' => $search->hasEngagement(),
                ],

            ]
        ];
    }

    private static function describeLocations($locations)
    {
        return collect($locations)->map(fn ($id) => Area::find($id)->fullName('en'))->values()->all();
    }

    private static function describeStudentAges($ages)
    {
        return collect($ages)
            ->map(fn ($age) => Lang::get('job_posts.student_ages.' . $age, [], 'en'))
            ->values()->all();
    }

    private static function describeBenefits($benefits)
    {
        return collect($benefits)
            ->map(fn ($benefit) => Lang::get('job_posts.benefits.' . $benefit, [], 'en'))
            ->values()->all();
    }

    private static function describeContractTypes($contracts)
    {
        return collect($contracts)
            ->map(fn ($contract) => Lang::get('job_posts.contract.' . $contract, [], 'en'))
            ->values()->all();
    }

    private static function describeSchedule($schedules)
    {
        return collect($schedules)
            ->map(fn ($schedule) => Lang::get('job_posts.schedule.' . $schedule, [], 'en'))
            ->values()->all();
    }

    private static function describeSalary($salary)
    {
        return Lang::get('job_search.salary.' . $salary, [], 'en');
    }

    private static function describeWeekends($weekends)
    {
        if($weekends) {
            return 'Okay with jobs that require work on Saturdays or Sundays.';
        }

        return 'Find jobs that don\'t require work on Saturdays or Sundays.';
    }

    private static function describeHours($hours)
    {
        return Lang::get('job_search.hours.' . $hours, [], 'en');
    }

    private static function describeEngagement($engagement)
    {
        return Lang::get('job_posts.engagement.' . $engagement, [], 'en');
    }
}
