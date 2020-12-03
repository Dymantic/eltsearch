<?php

namespace Tests\Feature\GuestApplications;

use App\Nation;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProfileTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_profile()
    {
        $this->withoutExceptionHandling();

        $post = factory(JobPost::class)->state('current')->create();
        $nation = factory(Nation::class)->create();

        $response = $this->asGuest()->post("guest-applications/profile", [
            'name'                    => 'test name',
            'email'                   => 'test@test.test',
            'password'                => 'password',
            'password_confirmation'   => 'password',
            'nation_id'             => $nation->id,
            'date_of_birth'           => '1999-09-19',
            'native_language'         => 'English',
            'other_languages'         => 'Spanish',
            'years_experience'        => 3,
            'education_level'         => Teacher::EDUCATION_GRADUATE,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);

        $response->assertRedirect("/guest-applications/add-experience");

        $this->assertDatabaseHas('users', [
            'name'         => 'test name',
            'email'        => 'test@test.test',
            'account_type' => User::ACCOUNT_TEACHER,
        ]);
        $user = User::where('email', 'test@test.test')->first();
        $teacher = Teacher::where('email', 'test@test.test')->first();

        $this->assertDatabaseHas('teachers', [
            'name'                    => 'test name',
            'email'                   => 'test@test.test',
            'nation_id'               => $nation->id,
            'date_of_birth'           => Carbon::parse('1999-09-19')->format('Y-m-d'),
            'native_language'         => 'English',
            'other_languages'         => 'Spanish',
            'years_experience'        => 3,
            'education_level'         => Teacher::EDUCATION_GRADUATE,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);

        $this->assertSame($user->id, session('guest_application.user_id'));
        $this->assertSame($teacher->id, session('guest_application.teacher_id'));

    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => '']);
    }

    /**
     *@test
     */
    public function the_email_is_required()
    {
        $this->assertFieldIsInvalid(['email' => '']);
    }

    /**
     *@test
     */
    public function the_email_must_be_valid()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_password_is_required()
    {
        $this->assertFieldIsInvalid(['password' => '']);
    }

    /**
     *@test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password' => 'password',
            'password_confirmation' => ''
        ]);
    }

    /**
     *@test
     */
    public function the_nation_id_must_exist()
    {
        $this->assertNull(Nation::find(99));

        $this->assertFieldIsInvalid(['nation_id' => 99]);
    }

    /**
     *@test
     */
    public function the_date_of_birth_is_required()
    {
        $this->assertFieldIsInvalid(['date_of_birth' => '']);
    }

    /**
     *@test
     */
    public function the_date_of_birth_must_be_a_date()
    {
        $this->assertFieldIsInvalid(['date_of_birth' => 'not-a-date-format']);
    }

    /**
     *@test
     */
    public function the_native_language_is_required()
    {
        $this->assertFieldIsInvalid(['native_language' => '']);
    }

    /**
     *@test
     */
    public function years_experience_is_required_as_int()
    {
        $this->assertFieldIsInvalid(['years_experience' => null]);
        $this->assertFieldIsInvalid(['years_experience' => 'not a number']);
    }

    /**
     *@test
     */
    public function the_educational_level_must_be_valid()
    {
        $this->assertFieldIsInvalid(['education_level' => null]);
        $this->assertFieldIsInvalid(['education_level' => 'not a valid level']);
    }

    /**
     *@test
     */
    public function the_education_institution_is_required()
    {
        $this->assertFieldIsInvalid(['education_institution' => null]);
    }

    /**
     *@test
     */
    public function the_education_qualification_is_required()
    {
        $this->assertFieldIsInvalid(['education_qualification' => null]);
    }

    private function assertFieldIsInvalid($field)
    {
        $nation = factory(Nation::class)->create();

        $valid = [
            'name'                    => 'test name',
            'email'                   => 'test@test.test',
            'password'                => 'password',
            'password_confirmation'   => 'password',
            'nation_id'             => $nation->id,
            'date_of_birth'           => '1999-09-19',
            'native_language'         => 'English',
            'other_languages'         => 'Spanish',
            'years_experience'        => 3,
            'education_level'         => Teacher::EDUCATION_GRADUATE,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ];

        $response = $this
            ->asGuest()
            ->from("/guest-applications/create-profile")
            ->post("guest-applications/profile", array_merge($valid, $field));

        $response->assertRedirect("/guest-applications/create-profile");
        $response->assertSessionHasErrors(array_key_first($field));
    }


}
