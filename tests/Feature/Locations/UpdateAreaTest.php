<?php


namespace Tests\Feature\Locations;


use App\Locations\Area;
use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateAreaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_area()
    {
        $this->withoutExceptionHandling();

        $area = factory(Area::class)->create();

        $response = $this->asAdmin()->postJson("/api/areas/{$area->id}", [
            'name' => ['en' => "new name", 'zh' => "zh new name"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('areas', [
            'id'   => $area->id,
            'name' => json_encode(['en' => "new name", 'zh' => "zh new name"]),
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $area = factory(Area::class)->create();

        $response = $this->asAdmin()->postJson("/api/areas/{$area->id}", [
            'name' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_name_must_be_unique_for_the_areas_region()
    {
        $area = factory(Area::class)->create();
        factory(Area::class)->create([
            'region_id' => $area->region->id,
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/areas/{$area->id}", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/areas/{$area->id}", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/areas/{$area->id}", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function can_update_a_single_translation()
    {
        $area = factory(Area::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/areas/{$area->id}", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertSuccessful();
    }
}
