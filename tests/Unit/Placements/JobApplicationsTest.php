<?php


namespace Tests\Unit\Placements;


use App\ContactPersonInfo;
use App\Placements\JobApplication;
use App\Placements\ShowOfInterest;
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
}
