<?php


namespace Tests\Unit\Schools;


use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class SchoolLogoTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('media', config('filesystems.disks.media'));
    }

    /**
     *@test
     */
    public function can_set_the_school_logo()
    {
        $school = factory(School::class)->create();
        $upload = UploadedFile::fake()->image('test_logo.jpg');

        $logo = $school->setLogo($upload);

        $this->assertInstanceOf(Media::class, $logo);
        $this->assertTrue($logo->model->is($school));

        Storage::disk('media')->assertExists(Str::after($logo->getUrl(), '/media'));

        $this->assertTrue($logo->fresh()->hasGeneratedConversion('thumb'));
        Storage::disk('media')->assertExists(Str::after($logo->getUrl('thumb'), '/media'));
    }

    /**
     *@test
     */
    public function setting_a_logo_clears_any_previous_one()
    {
        $school = factory(School::class)->create();
        $school->setLogo(UploadedFile::fake()->image('test_one.png'));
        $this->assertCount(1, $school->getMedia(School::LOGOS));

        $new_logo = UploadedFile::fake()->image('test_logo.jpg');

        $logo = $school->setLogo($new_logo);

        $this->assertCount(1, $school->fresh()->getMedia(School::LOGOS));
        $this->assertStringContainsString($new_logo->hashName(), $logo->getUrl());
    }

    /**
     *@test
     */
    public function can_clear_logo()
    {
        $school = factory(School::class)->create();
        $school->setLogo(UploadedFile::fake()->image('test_one.png'));
        $this->assertCount(1, $school->getMedia(School::LOGOS));

        $school->clearLogo();

        $this->assertCount(0, $school->fresh()->getMedia(School::LOGOS));
    }
}
