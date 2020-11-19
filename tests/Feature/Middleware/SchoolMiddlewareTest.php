<?php


namespace Tests\Feature\Middleware;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SchoolMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function only_schools_pass_school_middleware()
    {
        $teacher = factory(User::class)->state('teacher')->create();
        $school = factory(User::class)->state('school')->create();
        $admin = factory(User::class)->state('admin')->create();

        Route::get("/test-school-middleware", function() {
            return response("", 200);
        })->middleware("school");

        $response = $this->actingAs($school)->getJson("/test-school-middleware");
        $response->assertSuccessful();

        $response = $this->actingAs($teacher)->getJson("/test-school-middleware");
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($admin)->getJson("/test-school-middleware");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
