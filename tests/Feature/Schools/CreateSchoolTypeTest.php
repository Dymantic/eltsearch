<?php


namespace Tests\Feature\Schools;


use App\Schools\SchoolType;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateSchoolTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_new_school_type()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/api/admin/school-types", [
            'name' => ['en' => "test type", 'zh' => "zh test type"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('school_types', [
            'name' => json_encode(['en' => "test type", 'zh' => "zh test type"]),
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $response = $this->asAdmin()->postJson("/api/admin/school-types", [
            'name' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_name_must_be_a_unique_translation()
    {
        factory(SchoolType::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/admin/school-types", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/school-types", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/school-types", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/school-types", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }


}
