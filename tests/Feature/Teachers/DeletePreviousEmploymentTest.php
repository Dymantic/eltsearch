<?php


namespace Tests\Feature\Teachers;


use App\Teachers\PreviousEmployment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePreviousEmploymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_a_previous_employment_from_teacher()
    {
        $this->withoutExceptionHandling();

        $employment = factory(PreviousEmployment::class)->create();

        $response = $this->actingAs($employment->teacher->user)
            ->deleteJson("/api/teachers/previous-employments/{$employment->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('previous_employments', ['id' => $employment->id]);
    }

    /**
     *@test
     */
    public function cannot_delete_another_teachers_employment()
    {
        $employment = factory(PreviousEmployment::class)->create();
        $other_teacher = factory(User::class)->state('teacher')->create();

        $response = $this->actingAs($other_teacher)
                         ->deleteJson("/api/teachers/previous-employments/{$employment->id}");
        $response->assertForbidden();
        $this->assertDatabaseHas('previous_employments', ['id' => $employment->id]);
    }
}
