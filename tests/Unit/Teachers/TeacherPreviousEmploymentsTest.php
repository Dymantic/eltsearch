<?php


namespace Tests\Unit\Teachers;


use App\Teachers\PreviousEmployment;
use App\Teachers\PreviousEmploymentInfo;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TeacherPreviousEmploymentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_previous_employment_for_teacher()
    {
        $teacher = factory(Teacher::class)->create();

        $employment_info = new PreviousEmploymentInfo([
            'employer' => 'test employer',
            'start_month' => 1,
            'start_year' => 2010,
            'end_month' => 11,
            'end_year' => 2010,
            'job_title' => 'test job title',
            'description' => 'test description',
        ]);

        $employment = $teacher->addPreviousEmployment($employment_info);

        $this->assertInstanceOf(PreviousEmployment::class, $employment);
        $this->assertSame('test employer', $employment->employer);
        $this->assertTrue(Carbon::parse('2010-01-01')->isSameDay($employment->employed_from));
        $this->assertTrue(Carbon::parse('2010-11-01')->isSameDay($employment->employed_to));
        $this->assertSame('test job title', $employment->job_title);
        $this->assertSame('test description', $employment->description);
    }
}
