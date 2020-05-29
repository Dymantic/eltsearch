<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherLogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function teacher_can_logout()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(User::class)->state('teacher')->create();

        $response = $this->actingAs($teacher)->post("/logout");
        $response->assertRedirect("/");

        $this->assertGuest();
    }
}
