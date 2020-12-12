<?php


namespace Tests\Feature\GuestApplications;


use App\Teachers\Teacher;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddPreviousExperienceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_previous_employments_to_guest_application()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id' => $teacher->id,
            'guest_application.user_id'    => $teacher->user_id,
        ]);

        $response = $this->asGuest()->post("/guest-applications/experience", [
            'experience' => [
                [
                    'start_month' => 1,
                    'start_year'  => 1999,
                    'end_month'   => 12,
                    'end_year'    => 2010,
                    'employer'    => 'test employer one',
                    'job_title'   => 'test title one',
                    'description' => 'test description one',
                ],
                [
                    'start_month' => 1,
                    'start_year'  => 2011,
                    'end_month'   => 12,
                    'end_year'    => 2020,
                    'employer'    => 'test employer two',
                    'job_title'   => 'test title two',
                    'description' => 'test description two',
                ]
            ]
        ]);
        $response->assertRedirect('/guest-applications/add-profile-image');

        $this->assertDatabaseHas('previous_employments', [
            'teacher_id'    => $teacher->id,
            'employer'      => 'test employer one',
            'job_title'     => 'test title one',
            'description'   => 'test description one',
            'employed_from' => Carbon::parse('1999-01-01')->format('Y-m-d'),
            'employed_to'   => Carbon::parse('2010-12-01')->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('previous_employments', [
            'teacher_id'    => $teacher->id,
            'employer'      => 'test employer two',
            'job_title'     => 'test title two',
            'description'   => 'test description two',
            'employed_from' => Carbon::parse('2011-01-01')->format('Y-m-d'),
            'employed_to'   => Carbon::parse('2020-12-01')->format('Y-m-d'),
        ]);

    }

    /**
     * @test
     */
    public function the_experience_must_be_present_as_an_array()
    {
        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id' => $teacher->id,
            'guest_application.user_id'    => $teacher->user_id,
        ]);

        $response = $this
            ->asGuest()
            ->from('/guest-application/add-experience')
            ->post("/guest-applications/experience", [
                'experience' => null,
            ]);
        $response->assertRedirect('/guest-application/add-experience');
        $response->assertSessionHasErrors('experience');

        $response = $this
            ->asGuest()
            ->from('/guest-application/add-experience')
            ->post("/guest-applications/experience", [
                'experience' => 'not-an-array',
            ]);
        $response->assertRedirect('/guest-application/add-experience');
        $response->assertSessionHasErrors('experience');
    }

    /**
     * @test
     */
    public function the_employer_is_required()
    {
        $this->assertFieldIsInvalid(['employer' => null]);
    }

    /**
     * @test
     */
    public function the_job_title_is_required()
    {
        $this->assertFieldIsInvalid(['job_title' => null]);
    }

    /**
     * @test
     */
    public function the_start_month_is_required()
    {
        $this->assertFieldIsInvalid(['start_month' => null]);
    }

    /**
     * @test
     */
    public function the_start_month_must_be_a_valid_month_integer()
    {
        $this->assertFieldIsInvalid(['start_month' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['start_month' => 0]);
        $this->assertFieldIsInvalid(['start_month' => 13]);
        $this->assertFieldIsInvalid(['start_month' => -10]);
        $this->assertFieldIsInvalid(['start_month' => 1.5]);
    }

    /**
     * @test
     */
    public function the_start_year_is_required()
    {
        $this->assertFieldIsInvalid(['start_year' => null]);
    }

    /**
     * @test
     */
    public function the_start_tear_must_be_a_valid_year_integer()
    {
        $this->assertFieldIsInvalid(['start_year' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['start_year' => 1800]);
        $this->assertFieldIsInvalid(['start_year' => -1800]);
        $this->assertFieldIsInvalid(['start_year' => 1.25]);
        $this->assertFieldIsInvalid(['start_year' => 2500]);
    }

    /**
     * @test
     */
    public function the_experience_end_month_is_required_with_the_end_year()
    {
        $this->assertFieldIsInvalid([
            'end_month' => null,
            'end_year'  => 2010,
        ]);
    }

    /**
     * @test
     */
    public function the_end_year_is_required_with_the_end_month()
    {
        $this->assertFieldIsInvalid([
            'end_year'  => null,
            'end_month' => 5,
        ]);
    }

    /**
     * @test
     */
    public function the_end_month_must_be_a_valid_month_integer()
    {
        $this->assertFieldIsInvalid(['end_month' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['end_month' => 0]);
        $this->assertFieldIsInvalid(['end_month' => 13]);
        $this->assertFieldIsInvalid(['end_month' => -10]);
        $this->assertFieldIsInvalid(['end_month' => 1.5]);
    }

    /**
     * @test
     */
    public function the_end_year_must_be_a_valid_year_integer()
    {
        $this->assertFieldIsInvalid(['end_year' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['end_year' => 1800]);
        $this->assertFieldIsInvalid(['end_year' => -1800]);
        $this->assertFieldIsInvalid(['end_year' => 1.25]);
        $this->assertFieldIsInvalid(['end_year' => 2500]);
    }

    private function assertFieldIsInvalid($field)
    {
        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id' => $teacher->id,
            'guest_application.user_id'    => $teacher->user_id,
        ]);

        $valid = [
            'start_month' => 1,
            'start_year'  => 1999,
            'end_month'   => 12,
            'end_year'    => 2010,
            'employer'    => 'test employer one',
            'job_title'   => 'test title one',
            'description' => 'test description one',
        ];

        $response = $this
            ->asGuest()
            ->from('/guest-applications/add-experience')
            ->post("/guest-applications/experience", [
                'experience' => [
                    array_merge($valid, $field),
                ]
            ]);
        $response->assertRedirect('/guest-applications/add-experience');
        $response->assertSessionHasErrors("experience.0." . array_key_first($field));
    }
}
