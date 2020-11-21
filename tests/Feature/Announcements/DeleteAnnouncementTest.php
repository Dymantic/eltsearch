<?php


namespace Tests\Feature\Announcements;


use App\Announcements\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_announcement()
    {
        $this->withoutExceptionHandling();

        $announcement = factory(Announcement::class)->create();

        $response = $this->asAdmin()->deleteJson("/api/admin/announcements/{$announcement->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('announcements', ['id' => $announcement->id]);
    }
}
