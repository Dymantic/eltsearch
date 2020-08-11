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

class UploadSchoolLogoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_logo_for_school()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/logos", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $school->getMedia(School::LOGOS));

        Storage::disk('media')
               ->assertExists(Str::after($school->getFirstMedia(School::LOGOS)->getUrl(), '/media'));
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
        $this->assertUploadIsInvalid('not-a-real-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('just-a-doc.txt'));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/logos", [
            'image' => $upload,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }


}
