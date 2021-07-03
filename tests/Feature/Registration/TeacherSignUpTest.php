<?php

namespace Tests\Feature\Registration;

use App\Recaptcha;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TeacherSignUpTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function teacher_can_register()
    {
        Http::fake([
            Recaptcha::VALIDATE_ENDPOINT => Http::response([
                'success' => true,
                'score' => Recaptcha::THRESHOLD + 0.1
            ]),
        ]);
        $this->withoutExceptionHandling();

        $response = $this->asGuest()->post("/register/teacher", [
            'name' => 'test name',
            'email' => 'test@test.test',
            'password' => 'test_password',
            'password_confirmation' => 'test_password',
        ]);
        $response->assertRedirect("/teachers");

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.test',
            'name' => 'test name',
            'account_type' => User::ACCOUNT_TEACHER,
        ]);

        $this->assertCount(1, User::all());

        $this->assertTrue(Hash::check('test_password', User::first()->password));
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => null]);
    }

    /**
     *@test
     */
    public function the_email_is_required()
    {
        $this->assertFieldIsInvalid(['email' => null]);
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_email()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-real-email']);
    }

    /**
     *@test
     */
    public function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'used@email.test']);
        $this->assertFieldIsInvalid(['email' => 'used@email.test']);
    }

    /**
     *@test
     */
    public function the_password_is_required()
    {
        $this->assertFieldIsInvalid(['password' => null]);
    }

    /**
     *@test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password' => 'test_password',
            'password_confirmation' => 'not-a-match'
        ]);
    }

    /**
     *@test
     */
    public function the_password_must_be_at_least_eight_characters()
    {
        $this->assertFieldIsInvalid(['password' => '2short']);
    }

    private function assertFieldIsInvalid($field)
    {
        Http::fake([
            Recaptcha::VALIDATE_ENDPOINT => Http::response([
                'success' => true,
                'score' => Recaptcha::THRESHOLD + 0.1
            ]),
        ]);

        $valid = [
            'name' => 'test name',
            'email' => 'test@test.test',
            'password' => 'test_password',
            'password_confirmation' => 'test_password',
        ];

        $response = $this
            ->from("/register/teacher")
            ->asGuest()
            ->post("/register/teacher", array_merge($valid, $field));
        $response->assertRedirect("/register/teacher#teachers");

        $response ->assertSessionHasErrors(array_key_first($field));
    }
}
