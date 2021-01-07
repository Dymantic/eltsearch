<?php


namespace Tests\Unit\Placements;


use App\ContactPersonInfo;
use App\Exceptions\RecruitmentException;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Placements\ShowOfInterest;
use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function show_interest_in_applicant()
    {
        $application = factory(JobApplication::class)->create();

        $contactPerson = new ContactPersonInfo([
            'contact_name' => 'test name',
            'email'        => 'test@test.test',
            'phone'        => 'test phone',
        ]);

        $show_of_interest = $application->showInterest($contactPerson);

        $this->assertInstanceOf(ShowOfInterest::class, $show_of_interest);
        $this->assertSame('test name', $show_of_interest->name);
        $this->assertSame('test@test.test', $show_of_interest->email);
        $this->assertSame('test phone', $show_of_interest->phone);
        $this->assertSame($application->id, $show_of_interest->job_application_id);
    }

    /**
     *@test
     */
    public function disabled_school_cannot_show_interest()
    {
        $school = factory(School::class)->create(['disabled_on' => now()]);
        $job_post = factory(JobPost::class)->create(['school_id' => $school]);
        $application = factory(JobApplication::class)->create(['job_post_id' => $job_post]);

        $contactPerson = new ContactPersonInfo([
            'contact_name' => 'test name',
            'email'        => 'test@test.test',
            'phone'        => 'test phone',
        ]);

        try {
            $show_of_interest = $application->showInterest($contactPerson);
            $this->fail('expected recruitment exception to be thrown');
        } catch (RecruitmentException $e) {
            $this->assertSame(RecruitmentException::SCHOOL_DISABLED, $e->getMessage());
        }
    }
}
