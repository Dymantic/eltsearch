<?php


namespace Tests\Feature\Locations;


use App\Locations\Area;
use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateAreaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_an_area_to_an_existing_region()
    {
        $this->withoutExceptionHandling();

        $region = factory(Region::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/regions/{$region->id}/areas", [
            'name' => ['en' => "test area name", 'zh' => "zh test area name"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('areas', [
            'region_id' => $region->id,
            'name'      => json_encode(['en' => "test area name", 'zh' => "zh test area name"]),
        ]);
    }

    /**
     *@test
     */
    public function area_name_is_required_in_at_least_one_translation()
    {
        $region = factory(Region::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/regions/{$region->id}/areas", [
            'name' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_area_name_must_be_unique_in_its_region()
    {
        $region = factory(Region::class)->create();
        factory(Area::class)->create([
            'region_id' => $region->id,
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/admin/regions/{$region->id}/areas", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/regions/{$region->id}/areas", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/regions/{$region->id}/areas", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }
}
