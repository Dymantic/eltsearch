<?php

namespace Tests\Feature\Teachers;

use App\DateFormatter;
use App\Locations\Area;
use App\Nation;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdateTeacherProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_a_teachers_profile()
    {
        $this->withoutExceptionHandling();
        $area = factory(Area::class)->create();
        $teacher = factory(Teacher::class)->create([
            'area_id' => $area->id,
        ]);
        $nation = factory(Nation::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/profile/general", [
            'name'             => 'test name',
            'nation_id'        => $nation->id,
            'email'            => 'test@test.test',
            'date_of_birth'    => Carbon::today()->subYears(35)->format(DateFormatter::STANDARD),
            'native_language'  => 'test native language',
            'other_languages'  => 'test other languages',
            'years_experience' => 4
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'               => $teacher->id,
            'user_id'          => $teacher->user->id,
            'area_id'          => $area->id,
            'name'             => 'test name',
            'nation_id'        => $nation->id,
            'email'            => 'test@test.test',
            'date_of_birth'    => Carbon::today()->subYears(35),
            'native_language'  => 'test native language',
            'other_languages'  => 'test other languages',
            'years_experience' => 4,
        ]);
    }

    /**
     * @test
     */
    public function a_teacher_can_have_an_unsupported_nationality()
    {
        $this->withoutExceptionHandling();
        $area = factory(Area::class)->create();
        $teacher = factory(Teacher::class)->create([
            'area_id' => $area->id,
        ]);

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/profile/general", [
            'name'             => 'test name',
            'nation_id'        => null,
            'nation_other'     => 'test unsupported nation',
            'email'            => 'test@test.test',
            'date_of_birth'    => Carbon::today()->subYears(35)->format(DateFormatter::STANDARD),
            'native_language'  => 'test native language',
            'other_languages'  => 'test other languages',
            'years_experience' => 4
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'               => $teacher->id,
            'user_id'          => $teacher->user->id,
            'area_id'          => $area->id,
            'name'             => 'test name',
            'nation_id'        => null,
            'nation_other'     => 'test unsupported nation',
            'email'            => 'test@test.test',
            'date_of_birth'    => Carbon::today()->subYears(35),
            'native_language'  => 'test native language',
            'other_languages'  => 'test other languages',
            'years_experience' => 4,
        ]);
    }

    /**
     * @test
     */
    public function empty_and_null_fields_are_allowed()
    {
        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/profile/general", [
            'name'             => null,
            'nation_id'        => null,
            'nation_other'     => 'test nation',
            'email'            => null,
            'date_of_birth'    => null,
            'native_language'  => null,
            'other_languages'  => null,
            'years_experience' => null,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'              => $teacher->id,
            'user_id'         => $teacher->user->id,
            'name'            => '',
            'nation_id'       => null,
            'email'           => '',
            'date_of_birth'   => null,
            'native_language' => '',
            'other_languages' => '',
            'nation_other'     => 'test nation',
        ]);
    }

    /**
     * @test
     */
    public function a_non_teaching_user_cannot_update_a_teachers_profile()
    {
        $user = factory(User::class)->state('school')->create();
        $area = factory(Area::class)->create();
        $nation = factory(Nation::class)->create();

        $response = $this->actingAs($user)->postJson("/api/teachers/profile/general", [
            'name'          => 'test name',
            'nation_id'     => $nation->id,
            'email'         => 'test@test.test',
            'date_of_birth' => Carbon::today()->subYears(35)->format(DateFormatter::STANDARD),
            'area_id'       => $area->id,
        ]);

        $response->assertForbidden();
    }


    /**
     * @test
     */
    public function the_email_must_be_a_valid_email_address()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     * @test
     */
    public function the_years_experience_should_be_an_integer()
    {
        $this->assertFieldIsInvalid(['years_experience' => 'not-a-number']);
    }

    /**
     * @test
     */
    public function the_date_of_birth_must_be_a_real_date()
    {
        $this->assertFieldIsInvalid(['date_of_birth' => 'not-a-date-just-like-high-school']);
    }

    /**
     * @test
     */
    public function the_nation_other_is_required_when_nation_id_is_null()
    {
        $this->assertFieldIsInvalid([
            'nation_other' => '',
            'nation_id'    => null,
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $teacher = factory(Teacher::class)->create();
        $area = factory(Area::class)->create();
        $nation = factory(Nation::class)->create();
        $valid = [
            'name'          => 'test name',
            'nation_id'     => $nation->id,
            'email'         => 'test@test.test',
            'date_of_birth' => Carbon::today()->subYears(35)->format(DateFormatter::STANDARD),
            'area_id'       => $area->id,
        ];

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/profile/general", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
