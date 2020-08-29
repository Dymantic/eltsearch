<?php


namespace Tests\Feature\Locations;


use App\Locations\Area;
use App\Locations\Country;
use App\Locations\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCountryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function delete_a_country()
    {
        $this->withoutExceptionHandling();

        $country = factory(Country::class)->create();
        $region = factory(Region::class)->create([
            'country_id' => $country->id,
        ]);
        $area = factory(Area::class)->create([
            'region_id' => $region->id,
        ]);

        $response = $this->asAdmin()->deleteJson("/api/admin/countries/{$country->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('countries', ['id' => $country->id]);
        $this->assertDatabaseMissing('regions', ['id' => $region->id]);
        $this->assertDatabaseMissing('areas', ['id' => $area->id]);
    }
}
