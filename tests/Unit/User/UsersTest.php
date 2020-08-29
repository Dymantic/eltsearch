<?php


namespace Tests\Unit\User;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_reset_user_password()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $user->resetPassword('new-password');

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }
}
