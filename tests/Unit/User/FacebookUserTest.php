<?php


namespace Tests\Unit\User;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacebookUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_create_a_teacher_from_fb_credentials()
    {
        $creds = [
            'name' => 'test fb user',
            'email' => 'test@test.test',
            'id' => 'test_fb_id'
        ];

        $user = User::registerTeacherViaFacebook($creds);

        $this->assertSame('test fb user', $user->name);
        $this->assertSame('test@test.test', $user->email);
        $this->assertSame(User::PLATFORM_FACEBOOK, $user->platform);
        $this->assertSame('test_fb_id', $user->provider_user_id);

        $this->assertNotNull($user->teacher);
        $this->assertSame('test fb user', $user->teacher->name);
        $this->assertSame('test@test.test', $user->teacher->email);

    }

    /**
     *@test
     */
    public function can_find_a_registered_fb_user()
    {
        $creds = [
            'name' => 'test fb user',
            'email' => 'test@test.test',
            'id' => 'test_fb_id'
        ];

        $existing = factory(User::class)->state('facebook')->create([
            'name' => 'test fb user',
            'email' => 'test@test.test',
            'provider_user_id' => 'test_fb_id'
        ]);

        $user = User::findFacebookUser($creds);
        $shouldnt_exist = User::findFacebookUser([
            'name' => 'not a test fb user',
            'email' => 'not-test@test.test',
            'id' => 'non_test_fb_id'
        ]);

        $this->assertTrue($user->is($existing));
        $this->assertNull($shouldnt_exist);


    }
}
