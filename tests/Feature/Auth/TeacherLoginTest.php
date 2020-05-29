<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TeacherLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function registered_teacher_can_login()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(User::class)->state('teacher')->create();

        $response = $this->asGuest()->post("/login", [
            'email' => $teacher->email,
            'password' => 'password'
        ]);

        $response->assertRedirect("/teachers");

        $this->assertTrue(Auth::user()->is($teacher));
    }

    /**
     *@test
     */
    public function false_email_cannot_be_used()
    {

        factory(User::class)->state('teacher')->create([
            'email' => 'real@email.test'
        ]);

        $response = $this->from("/login")->asGuest()->post("/login", [
            'email' => 'fake@email.test',
            'password' => 'password'
        ]);

        $response->assertRedirect("/login");

        $this->assertGuest();
    }

    /**
     *@test
     */
    public function incorrect_password_cannot_be_used()
    {
        factory(User::class)->state('teacher')->create([
            'email' => 'real@email.test'
        ]);

        $response = $this->from("/login")->asGuest()->post("/login", [
            'email' => 'real@email.test',
            'password' => 'incorrect_password'
        ]);

        $response->assertRedirect("/login");

        $this->assertGuest();
    }
}
