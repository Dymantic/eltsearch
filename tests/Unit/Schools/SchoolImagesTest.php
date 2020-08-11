<?php


namespace Tests\Unit\Schools;


use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class SchoolImagesTest extends TestCase
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
    public function add_image_to_school()
    {
        $school = factory(School::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $school->addImage($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($image->model->is($school));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
    }

    /**
     *@test
     */
    public function school_knows_if_it_has_max_images()
    {
        $school = factory(School::class)->create();

        $this->assertCount(0, $school->getMedia(School::IMAGES));
        $this->assertFalse($school->hasMaxImages());

        foreach (range(1, School::MAX_IMAGES) as $index) {
            $school->addImage(UploadedFile::fake()->image("test-pic{$index}.jpg"));
        }

        $this->assertCount(School::MAX_IMAGES, $school->fresh()->getMedia(School::IMAGES));
        $this->assertTrue($school->fresh()->hasMaxImages());

    }
}
