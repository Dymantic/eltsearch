<?php


namespace Tests\Feature\Placements;


use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class DeleteJobPostImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_job_post_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $image = $post->addImage(UploadedFile::fake()->image('test.png'));

        $response = $this
            ->actingAs($owner)
            ->deleteJson("/api/job-posts/{$post->id}/images/{$image->id}");

        $response->assertSuccessful();

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
        $this->assertCount(0, $post->getMedia(JobPost::IMAGES));
    }

    /**
     *@test
     */
    public function cannot_delete_an_image_that_does_not_belong_to_users_school()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $image = $post->addImage(UploadedFile::fake()->image('test.png'));
        $another_school = factory(User::class)->state('school')->create();

        $response = $this
            ->actingAs($another_school)
            ->deleteJson("/api/job-posts/{$post->id}/images/{$image->id}");

        $response->assertForbidden();

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }
}
