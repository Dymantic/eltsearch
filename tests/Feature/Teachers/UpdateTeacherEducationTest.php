<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTeacherEducationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_teachers_education()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/profile/education", [
            'education_level'         => Teacher::EDUCATION_BACHELOR,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'                      => $teacher->id,
            'education_level'         => Teacher::EDUCATION_BACHELOR,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);
    }

    /**
     *@test
     */
    public function empty_fields_are_allowed()
    {
        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/profile/education", [
            'education_level'         => '',
            'education_institution'   => '',
            'education_qualification' => '',
        ]);
        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_education_level_must_be_one_of_allowed_levels_if_present()
    {
        $this->assertFieldIsInvalid(['education_level' => 'not-in-allowed-list']);
    }

    private function assertFieldIsInvalid($field)
    {
        $teacher = factory(Teacher::class)->create();
        $valid = [
            'education_level'         => Teacher::EDUCATION_BACHELOR,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ];

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/profile/education", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
