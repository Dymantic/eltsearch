<?php


namespace Tests\Feature\Middleware;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function only_admins_pass_admin_middleware()
    {
        $teacher = factory(User::class)->state('teacher')->create();
        $school = factory(User::class)->state('school')->create();
        $admin = factory(User::class)->state('admin')->create();

        Route::get("/test-admin-middleware", function() {
            return response("", 200);
        })->middleware("admin");

        $response = $this->actingAs($admin)->getJson("/test-admin-middleware");
        $response->assertSuccessful();

        $response = $this->actingAs($teacher)->getJson("/test-admin-middleware");
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($school)->getJson("/test-admin-middleware");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
