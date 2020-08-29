<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_reset_their_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->postJson("/api/me/reset-password", [
            'old_password'          => 'old-password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSuccessful();

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    /**
     *@test
     */
    public function the_current_password_is_required()
    {
        $this->assertFieldIsInvalid(['old_password' => null]);
    }

    /**
     *@test
     */
    public function the_old_password_must_be_the_current_users_password()
    {
        //ral password is 'old-password'
        $this->assertFieldIsInvalid(['old_password' => 'not-current-password']);
    }

    /**
     *@test
     */
    public function the_password_must_be_at_least_8_characters()
    {
        $this->assertFieldIsInvalid([
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
    }

    /**
     *@test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password' => 'new_password',
            'password_confirmation' => null,
        ]);

        $this->assertFieldIsInvalid([
            'password' => 'new_password',
            'password_confirmation' => 'different-to-above',
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $valid = [
            'old_password'          => 'old-password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ];

        $response = $this
            ->actingAs($user)
            ->postJson("/api/me/reset-password", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
