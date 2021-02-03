<?php

namespace Tests\Unit\Announcements;

use App\Announcements\Announcement;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_announcement_can_be_current()
    {
        $announcement = factory(Announcement::class)->state('current')->create();
        $old_announcement = factory(Announcement::class)->create([
            'starts' => now()->subDays(7),
            'ends' => now()->subDays(3),
        ]);
        $future_announcement = factory(Announcement::class)->create([
            'starts' => now()->addDays(3),
            'ends' => now()->addDays(5),
        ]);

        $this->assertTrue($announcement->isCurrent());
        $this->assertFalse($old_announcement->isCurrent());
        $this->assertFalse($future_announcement->isCurrent());
    }

    /**
     *@test
     */
    public function can_get_current_public_announcement_for_lang()
    {
        $announcement = factory(Announcement::class)->state('current')->create([
            'type' => Announcement::PUBLIC
        ]);
        [$fetched, $urgent] = Announcement::currentPublic('en');

        $this->assertStringContainsString($announcement->body->in('en'), $fetched);
    }

    /**
     *@test
     */
    public function can_get_current_schools_announcement_for_lang()
    {
        $announcement = factory(Announcement::class)->state('current')->create([
            'type' => Announcement::FOR_SCHOOLS
        ]);
        [$fetched, $urgent] = Announcement::currentSchools('zh');

        $this->assertStringContainsString($announcement->body->in('zh'), $fetched);
    }

    /**
     *@test
     */
    public function can_get_current_teachers_announcement_for_lang()
    {
        $announcement = factory(Announcement::class)->state('current')->create([
            'type' => Announcement::FOR_TEACHERS
        ]);
        [$fetched, $urgent] = Announcement::currentTeachers('zh');

        $this->assertStringContainsString($announcement->body->in('zh'), $fetched);
    }

    /**
     *@test
     */
    public function current_means_latest_current_announcement()
    {
        $old_current = factory(Announcement::class)->state('current')->create([
            'type' => Announcement::PUBLIC
        ]);

        $this->travel(10)->minutes();

        $new_current = factory(Announcement::class)->state('current')->create([
            'type' => Announcement::PUBLIC
        ]);

        [$fetched, $urgent] = Announcement::currentPublic('en');

        $this->assertStringContainsString($new_current->body->in('en'), $fetched);
    }

    /**
     *@test
     */
    public function an_announcement_can_be_upcoming()
    {
        $upcoming = factory(Announcement::class)->state('upcoming')->create();
        $past = factory(Announcement::class)->create([
            'starts' => now()->subDays(7),
            'ends' => now()->subDays(3),
        ]);

        $this->assertTrue($upcoming->isUpcoming());
        $this->assertFalse($past->isUpcoming());
    }

    /**
     *@test
     */
    public function an_announcement_can_use_markdown()
    {
        $announcement = factory(Announcement::class)->state('current')->create([
            'type' => Announcement::PUBLIC,
            'body' => new Translation([
                'en' => 'This has a [link](https://test.test)',
                'zh' => 'zh body'
            ])
        ]);

        $expected = 'This has a <a href="https://test.test">link</a>';

        $this->assertStringContainsString($expected, Announcement::currentPublic('en')[0]);
    }
}
