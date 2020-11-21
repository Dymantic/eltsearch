<?php


namespace Tests\Feature\Announcements;


use App\Announcements\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_announcement()
    {
        $this->withoutExceptionHandling();

        $announcement = factory(Announcement::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/announcements/{$announcement->id}", [
            'body'   => ['en' => 'new body', 'zh' => 'zh new body'],
            'starts' => now()->addDays(3)->format('Y-m-d'),
            'ends'   => now()->addDays(10)->format('Y-m-d'),
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('announcements', [
            'body'   => $this->asJson(['en' => 'new body', 'zh' => 'zh new body'], 'body'),
            'starts' => now()->addDays(3)->format('Y-m-d'),
            'ends'   => now()->addDays(10)->format('Y-m-d'),
            'type' => $announcement->type,
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
        $announcement = factory(Announcement::class)->create();

        $valid = [
            'body'   => ['en' => 'new body', 'zh' => 'zh new body'],
            'starts' => now()->addDays(3)->format('Y-m-d'),
            'ends'   => now()->addDays(10)->format('Y-m-d'),
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/api/admin/announcements/{$announcement->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
