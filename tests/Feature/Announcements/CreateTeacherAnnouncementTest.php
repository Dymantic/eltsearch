<?php


namespace Tests\Feature\Announcements;


use App\Announcements\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTeacherAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_an_announcement_for_teachers()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson('/api/admin/teacher-announcements', [
            'body'   => ['en' => 'test body', 'zh' => 'zh test body'],
            'starts' => now()->format('Y-m-d'),
            'ends'   => now()->addDays(7)->format('Y-m-d'),
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('announcements', [
            'body'   => $this->asJson(['en' => "test body", 'zh' => "zh test body"], 'body'),
            'starts' => now()->format('Y-m-d'),
            'ends'   => now()->addDays(7)->format('Y-m-d'),
            'type'   => Announcement::FOR_TEACHERS,
        ]);
    }

    /**
     * @test
     */
    public function the_body_is_required_as_a_translation()
    {
        $this->assertFieldIsInvalid(['body' => null]);
        $this->assertFieldIsInvalid(['body' => 'not-a-translation']);
    }

    /**
     * @test
     */
    public function starts_is_required_as_date()
    {
        $this->assertFieldIsInvalid(['starts' => 'not-a-date']);
    }

    /**
     * @test
     */
    public function ends_is_required_as_a_date()
    {
        $this->assertFieldIsInvalid(['ends' => 'not-a-date']);
    }

    /**
     *@test
     */
    public function the_end_date_must_be_after_the_start_date()
    {
        $this->assertFieldIsInvalid([
            'ends' => now()->format('Y-m-d'),
            'starts' => now()->addDay()->format('Y-m-d'),
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'body'   => ['en' => 'test body', 'zh' => 'zh test body'],
            'starts' => now()->format('Y-m-d'),
            'ends'   => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this
            ->asAdmin()
            ->postJson('/api/admin/teacher-announcements', array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
