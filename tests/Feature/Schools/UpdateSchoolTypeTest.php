<?php


namespace Tests\Feature\Schools;


use App\Schools\SchoolType;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateSchoolTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_school_type()
    {
        $this->withoutExceptionHandling();

        $type = factory(SchoolType::class)->create();

        $response = $this->asAdmin()->postJson("/api/school-types/{$type->id}", [
            'name' => ['en' => "new name", 'zh' => "zh new name"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('school_types', [
            'id'   => $type->id,
            'name' => json_encode(['en' => "new name", 'zh' => "zh new name"]),
        ]);
    }

    /**
     *@test
     */
    public function the_school_type_is_required_in_at_least_one_language()
    {
        $type = factory(SchoolType::class)->create();

        $response = $this->asAdmin()->postJson("/api/school-types/{$type->id}", [
            'name' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_name_must_be_unique_across_translations()
    {
        $type = factory(SchoolType::class)->create();
        factory(SchoolType::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/school-types/{$type->id}", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/school-types/{$type->id}", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function can_update_a_single_translation()
    {
        $type = factory(SchoolType::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/school-types/{$type->id}", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertSuccessful();
    }
}
