<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetTeacherProfilePublicTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_a_teachers_profile_as_public()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->state('private')->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/public-teachers");
        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'is_public' => true,
        ]);
    }
}
