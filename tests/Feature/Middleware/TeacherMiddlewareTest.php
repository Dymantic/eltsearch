<?php

namespace Test\Feature\Middleware;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TeacherMiddlewareTest extends TestCase {
    use RefreshDatabase;

    /**
     *@test
     */
    public function only_teachers_pass_teacher_middleware()
    {
        $teacher = factory(User::class)->state('teacher')->create();
        $school = factory(User::class)->state('school')->create();
        $admin = factory(User::class)->state('admin')->create();

        Route::get("/test-teacher-middleware", function() {
            return response("", 200);
        })->middleware("teacher");

        $response = $this->actingAs($teacher)->getJson("/test-teacher-middleware");
        $response->assertSuccessful();

        $response = $this->actingAs($school)->getJson("/test-teacher-middleware");
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($admin)->getJson("/test-teacher-middleware");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
