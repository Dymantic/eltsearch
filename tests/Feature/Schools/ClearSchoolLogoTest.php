<?php


namespace Tests\Feature\Schools;


use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearSchoolLogoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_existing_logo_from_school()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        list($school, $owner) = $this->setUpSchool();
        $school->setLogo(UploadedFile::fake()->image('test_logo.png'));
        $this->assertCount(1, $school->getMedia(School::LOGOS));

        $response = $this->actingAs($owner)->deleteJson("/api/schools/{$school->id}/logos");
        $response->assertSuccessful();

        $this->assertCount(0, $school->fresh()->getMedia(School::LOGOS));
    }


}
