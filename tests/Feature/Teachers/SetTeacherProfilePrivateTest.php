<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetTeacherProfilePrivateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_teacher_profile_to_private()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->state('public')->create();

        $response = $this->actingAs($teacher->user)->deleteJson("/api/teachers/public-teachers");
        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'        => $teacher->id,
            'is_public' => false,
        ]);
    }
}
