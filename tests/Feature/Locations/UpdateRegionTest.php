<?php


namespace Tests\Feature\Locations;


use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateRegionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_an_existing_region()
    {
        $this->withoutExceptionHandling();

        $region = factory(Region::class)->create();

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => ['en' => "new name", 'zh' => "zh new name"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('regions', [
            'id' => $region->id,
            'name' => json_encode(['en' => "new name", 'zh' => "zh new name"]),
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $region = factory(Region::class)->create();

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_name_must_be_unique_in_its_country()
    {
        $region = factory(Region::class)->create();
        factory(Region::class)->create([
            'country_id' => $region->country->id,
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => ['en' => "Used Name", 'zh' => "ZH used Name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_region_name_can_be_updated_in_a_single_language()
    {
        $region = factory(Region::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/regions/{$region->id}", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertSuccessful();
    }
}
