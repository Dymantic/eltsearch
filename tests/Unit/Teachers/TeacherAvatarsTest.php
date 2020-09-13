<?php


namespace Tests\Unit\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class TeacherAvatarsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_avatar_for_teacher()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $teacher = factory(Teacher::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $avatar = $teacher->setAvatar($upload);

        $this->assertInstanceOf(Media::class, $avatar);
        $this->assertTrue($avatar->model->is($teacher));

        $this->assertTrue($avatar->fresh()->hasGeneratedConversion('thumb'));
        $this->assertStringContainsString($upload->hashName(), $avatar->getPath());

        Storage::disk('media')->assertExists(Str::after($avatar->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($avatar->getUrl('thumb'), '/media'));
    }

    /**
     *@test
     */
    public function setting_the_avatar_clears_any_previous_ones()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $teacher = factory(Teacher::class)->create();
        $old_upload = UploadedFile::fake()->image('testpic.png');
        $teacher->setAvatar($old_upload);

        $new_upload = UploadedFile::fake()->image('testpic.jpg');
        $teacher->setAvatar($new_upload);

        $this->assertCount(1, $teacher->getMedia(Teacher::AVATAR));

        $this->assertStringContainsString($new_upload->hashName(), $teacher->fresh()->getFirstMedia(Teacher::AVATAR)->getPath());

    }
}
