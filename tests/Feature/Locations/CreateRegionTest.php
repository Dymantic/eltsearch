<?php


namespace Tests\Feature\Locations;


use App\Locations\Country;
use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateRegionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_new_region_to_a_country()
    {
        $this->withoutExceptionHandling();

        $country = factory(Country::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}/regions", [
            'name' => ['en' => "test name", 'zh' => "zh test name"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('regions', [
            'country_id' => $country->id,
            'name' => json_encode(['en' => "test name", 'zh' => "zh test name"]),
        ]);
    }

    /**
     *@test
     */
    public function the_region_name_is_required_in_at_least_one_country()
    {
        $country = factory(Country::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}/regions", [
            'name' => ['en' => "", 'zh' => null],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_region_name_must_be_unique_in_a_country()
    {
        $country = factory(Country::class)->create();
        factory(Region::class)->create([
            'country_id' => $country->id,
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"])
        ]);

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}/regions", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}/regions", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}/regions", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}/regions", [
            'name' => ['en' => "Used Name", 'zh' => "ZH used Name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }
}
