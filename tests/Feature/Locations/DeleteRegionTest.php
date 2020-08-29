<?php


namespace Tests\Feature\Locations;


use App\Locations\Area;
use App\Locations\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteRegionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_region_and_its_areas()
    {
        $this->withoutExceptionHandling();

        $region = factory(Region::class)->create();
        $areaA = factory(Area::class)->create(['region_id' => $region->id]);
        $areaB = factory(Area::class)->create(['region_id' => $region->id]);

        $response = $this->asAdmin()->deleteJson("/api/admin/regions/{$region->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('regions', ['id' => $region->id]);
        $this->assertDatabaseMissing('areas', ['id' => $areaA->id]);
        $this->assertDatabaseMissing('areas', ['id' => $areaB->id]);
    }
}
