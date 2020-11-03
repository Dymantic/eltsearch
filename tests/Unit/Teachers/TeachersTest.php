<?php

namespace Tests\Unit\Teachers;

use App\DateFormatter;
use App\Locations\Area;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use App\Teachers\TeacherGeneralInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TeachersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_update_general_info()
    {
        $area = factory(Area::class)->create();
        $teacher = factory(Teacher::class)->create();

        $general_info = new TeacherGeneralInfo([
            'name'          => 'test name',
            'nationality'   => 'test nationality',
            'email'         => 'test@test.test',
            'date_of_birth' => Carbon::today()->subYears(35)->format(DateFormatter::STANDARD),
            'area_id'       => $area->id,
            'native_language' => 'test native language',
            'other_languages' => 'test other languages'
        ]);

        $teacher->updateGeneralInfo($general_info);
        $teacher->refresh();

        $this->assertSame('test name', $teacher->name);
        $this->assertSame('test nationality', $teacher->nationality);
        $this->assertSame('test@test.test', $teacher->email);
        $this->assertSame('test native language', $teacher->native_language);
        $this->assertSame('test other languages', $teacher->other_languages);
        $this->assertTrue($teacher->date_of_birth->isSameDay(Carbon::today()->subYears(35)));
        $this->assertTrue($teacher->area->is($area));
    }

    /**
     *@test
     */
    public function can_update_teachers_education_info()
    {
        $teacher = factory(Teacher::class)->create();
        $education_info = new TeacherEducationInfo([
            'education_level'         => Teacher::EDUCATION_POSTGRAD,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);

        $teacher->updateEducationInfo($education_info);

        $this->assertSame(Teacher::EDUCATION_POSTGRAD, $teacher->education_level);
        $this->assertSame('test college', $teacher->education_institution);
        $this->assertSame('BTest', $teacher->education_qualification);

    }

    /**
     *@test
     */
    public function can_publish_a_teacher_profile()
    {
        $teacher = factory(Teacher::class)->state('private')->create();

        $teacher->publish();

        $this->assertTrue($teacher->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_retract_a_teacher()
    {
        $teacher = factory(Teacher::class)->state('public')->create();

        $teacher->retract();

        $this->assertFalse($teacher->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_get_the_current_job_search()
    {
        $teacher = factory(Teacher::class)->create();
        $jobSearch = factory(JobSearch::class)->create(['teacher_id' => $teacher->id]);

        $current = $teacher->currentJobSearch();

        $this->assertTrue($current->is($jobSearch));
    }


}
