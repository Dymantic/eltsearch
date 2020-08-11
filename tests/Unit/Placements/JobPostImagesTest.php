<?php


namespace Tests\Unit\Placements;


use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class JobPostImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_image_to_job_post()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $post = factory(JobPost::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $post->addImage($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($image->model->is($post));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }
}
