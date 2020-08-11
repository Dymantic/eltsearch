<?php


namespace Tests\Feature\Schools;


use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadSchoolImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_a_school()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $school->getMedia(School::IMAGES));
        $image = $school->fresh()->getFirstMedia(School::IMAGES);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));


    }

    /**
     *@test
     */
    public function cannot_upload_images_if_not_on_team()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $non_owner = factory(User::class)->state('school')->create();

        $response = $this->actingAs($non_owner)->postJson("/api/schools/{$school->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertForbidden();
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        $this->assertUploadIsInvalid(null);
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid('not-a-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-image.docx'));
    }

    /**
     *@test
     */
    public function cannot_upload_too_many_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();

        foreach (range(1, School::MAX_IMAGES) as $index) {
            $school->addImage(UploadedFile::fake()->image("test-pic{$index}.jpg"));
        }

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/images", [
            'image' => UploadedFile::fake()->image('one-too-many.png'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');




    }


    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/images", [
            'image' => $upload,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
