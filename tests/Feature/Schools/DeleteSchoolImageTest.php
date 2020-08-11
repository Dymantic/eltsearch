<?php


namespace Tests\Feature\Schools;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteSchoolImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_school_image()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $image = $school->addImage(UploadedFile::fake()->image('testpic.png'));

        $response = $this->actingAs($owner)->deleteJson("/api/schools/{$school->id}/images/{$image->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('media', ['id' => $image->id]);
    }
}
