<?php


namespace Tests\Feature\GuestApplications;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadGuestApplicantImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_profile_image_for_guest_applicant()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id' => $teacher->id,
            'guest_application.user_id'    => $teacher->user_id,
        ]);

        $response = $this->asGuest()->postJson("/guest-applications/profile-image", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $image = $teacher->fresh()->getFirstMedia(Teacher::AVATAR);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
    }

    /**
     *@test
     */
    public function the_image_is_required_as_an_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id' => $teacher->id,
            'guest_application.user_id'    => $teacher->user_id,
        ]);

        $response = $this->asGuest()->postJson("/guest-applications/profile-image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asGuest()->postJson("/guest-applications/profile-image", [
            'image' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asGuest()->postJson("/guest-applications/profile-image", [
            'image' => UploadedFile::fake()->create('not-image-file.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
