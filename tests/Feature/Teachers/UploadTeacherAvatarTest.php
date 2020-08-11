<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadTeacherAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_avatar_for_a_teacher()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/avatar", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $teacher->getMedia(Teacher::AVATAR));
        $avatar = $teacher->getFirstMedia(Teacher::AVATAR);

        Storage::disk('media')->assertExists(Str::after($avatar->getUrl(), '/media'));
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
        $this->assertUploadIsInvalid('not-even-a-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-an-image.txt'));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/avatar", [
            'image' => $upload,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
