<?php


namespace Tests\Feature\Placements;


use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadImageForJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_a_job_post()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($owner)->postJson("/api/job-posts/{$post->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $post->getMedia(JobPost::IMAGES));
        $image = $post->fresh()->getFirstMedia(JobPost::IMAGES);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function another_user_cannot_upload_images_to_post()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $another_user = factory(User::class)->state('school')->create();

        $response = $this->actingAs($another_user)->postJson("/api/job-posts/{$post->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertForbidden();
        $this->assertCount(0, $post->getMedia(JobPost::IMAGES));
    }

    /**
     *@test
     */
    public function the_upload_is_required()
    {
        $this->assertUploadIsInvalid(null);
    }

    /**
     *@test
     */
    public function the_upload_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid('not-even-a-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-an-image.txt'));
    }

    /**
     *@test
     */
    public function cannot_upload_too_many_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        foreach (range(1, JobPost::MAX_IMAGES) as $index) {
            $post->addImage(UploadedFile::fake()->image("test_{$index}.png"));
        }
        $this->assertCount(JobPost::MAX_IMAGES, $post->fresh()->getMedia(JobPost::IMAGES));

        $response = $this->actingAs($owner)->postJson("/api/job-posts/{$post->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $this->assertCount(JobPost::MAX_IMAGES, $post->fresh()->getMedia(JobPost::IMAGES));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($owner)->postJson("/api/job-posts/{$post->id}/images", [
            'image' => $upload,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
