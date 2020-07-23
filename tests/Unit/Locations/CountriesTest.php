<?php

namespace Tests\Unit\Locations;

use App\Locations\Area;
use App\Locations\Country;
use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_rename_a_country()
    {
        $country = factory(Country::class)->create();

        $country->rename(new Translation(['en' => "new name", 'zh' => "zh new name"]));

        $this->assertEquals(['en' => "new name", 'zh' => "zh new name"], $country->name->translations);
    }

    /**
     *@test
     */
    public function add_region_to_country()
    {
        $country = factory(Country::class)->create();
        $region_name = new Translation(['en' => "test region", 'zh' => "zh test region"]);

        $region = $country->addRegion($region_name);

        $this->assertInstanceOf(Region::class, $region);
        $this->assertSame($country->id, $region->country_id);
        $this->assertSame(['en' => "test region", 'zh' => "zh test region"], $region->name->translations);

    }

    /**
     *@test
     */
    public function can_fully_delete_country_with_all_regions_and_areas()
    {
        $country = factory(Country::class)->create();

        $regionA = factory(Region::class)->create(['country_id' => $country->id]);
        $regionB = factory(Region::class)->create(['country_id' => $country->id]);

        $areaA = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaB = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaC = factory(Area::class)->create(['region_id' => $regionB->id]);
        $areaD = factory(Area::class)->create(['region_id' => $regionB->id]);

        $country->fullDelete();

        $this->assertNull(Country::find($country->id));

        $this->assertNull(Region::find($regionA->id));
        $this->assertNull(Region::find($regionB->id));

        $this->assertNull(Area::find($areaA->id));
        $this->assertNull(Area::find($areaB->id));
        $this->assertNull(Area::find($areaC->id));
        $this->assertNull(Area::find($areaD->id));
    }
}
