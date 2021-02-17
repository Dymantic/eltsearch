<?php


namespace Tests\Feature\Registration;


use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SchoolSignUpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function sign_up_a_school()
    {
        $this->withoutExceptionHandling();

        $response = $this->asGuest()->post("/register/school", [
            'school_name'           => 'test school',
            'name'                  => 'test name',
            'email'                 => 'test@test.test',
            'password'              => 'test_password',
            'password_confirmation' => 'test_password',
            'preferred_lang'        => 'zh',
        ]);
        $response->assertRedirect("/schools");

        $this->assertDatabaseHas('users', [
            'name'         => 'test name',
            'email'        => 'test@test.test',
            'account_type' => User::ACCOUNT_SCHOOL,
            'preferred_lang' => 'zh',
        ]);

        $this->assertCount(1, User::all());
        $user = User::first();

        $this->assertTrue(Hash::check('test_password', $user->password));

        $this->assertDatabaseHas('schools', [
            'name' => 'test school',
        ]);

        $this->assertDatabaseHas('school_user', [
            'school_id'      => School::where('name', 'test school')->first()->id,
            'user_id'        => $user->id,
            'owner'          => true,
        ]);
    }

    /**
     * @test
     */
    public function the_users_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => null]);
    }

    /**
     * @test
     */
    public function the_email_is_required()
    {
        $this->assertFieldIsInvalid(['email' => null]);
    }

    /**
     * @test
     */
    public function the_email_must_be_valid_email()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-real-email']);
    }

    /**
     * @test
     */
    public function the_email_must_be_unique()
    {
        factory(User::class)->state('school')->create(['email' => 'used@email.test']);

        $this->assertFieldIsInvalid(['email' => 'used@email.test']);
    }

    /**
     * @test
     */
    public function the_password_is_required()
    {
        $this->assertFieldIsInvalid(['password' => null]);
    }

    /**
     * @test
     */
    public function the_password_must_be_at_least_eight_characters()
    {
        $this->assertFieldIsInvalid(['password' => '2short']);
    }

    /**
     * @test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'real-password',
            'password_confirmation' => 'different-password',
        ]);
    }

    /**
     * @test
     */
    public function the_school_name_is_required()
    {
        $this->assertFieldIsInvalid(['school_name' => null]);
    }

    /**
     * @test
     */
    public function the_school_name_must_be_unique()
    {
        factory(School::class)->create(['name' => 'test school']);

        $this->assertFieldIsInvalid(['school_name' => 'test school']);
    }

    /**
     *@test
     */
    public function the_preferred_lang_must_be_present()
    {
        $this->assertFieldIsInvalid(['preferred_lang' => null]);
    }

    /**
     *@test
     */
    public function the_preferred_lang_must_be_accepted_lang_code()
    {
        $this->assertFieldIsInvalid(['preferred_lang' => 'neither-en-nor-zh']);
    }


    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'school_name'           => 'test school',
            'school_address'        => 'test school address',
            'name'                  => 'test name',
            'email'                 => 'test@test.test',
            'password'              => 'test_password',
            'password_confirmation' => 'test_password',
            'preferred_lang'        => 'zh',
        ];

        $response = $this
            ->asGuest()
            ->from("/register/school")
            ->post("/register/school", array_merge($valid, $field));

        $response->assertRedirect("/register/school#schools");
        $response->assertSessionHasErrors(array_key_first($field));
    }
}
