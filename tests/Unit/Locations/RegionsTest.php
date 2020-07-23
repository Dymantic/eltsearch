<?php


namespace Tests\Unit\Locations;


use App\Locations\Area;
use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_rename_a_region()
    {
        $region = factory(Region::class)->create();
        $new_name = new Translation(['en' => "new name", 'zh' => "zh new name"]);

        $region->rename($new_name);

        $this->assertSame('new name', $region->fresh()->name->in('en'));
        $this->assertSame('zh new name', $region->fresh()->name->in('zh'));
    }

    /**
     *@test
     */
    public function can_add_an_area_to_a_region()
    {
        $region = factory(Region::class)->create();
        $area_name = new Translation(['en' => "test area name", 'zh' => "zh test area name"]);

        $area = $region->addArea($area_name);

        $this->assertInstanceOf(Area::class, $area);
        $this->assertSame($region->id, $area->region_id);
        $this->assertSame('test area name', $area->name->in('en'));
        $this->assertSame('zh test area name', $area->name->in('zh'));
    }

    /**
     *@test
     */
    public function can_full_delete_with_areas()
    {
        $region = factory(Region::class)->create();
        factory(Area::class)->create(['region_id' => $region->id]);
        factory(Area::class)->create(['region_id' => $region->id]);

        $region->fullDelete();

        $this->assertNull(Region::find($region->id));
        $this->assertCount(0, Area::where('region_id', $region->id)->get());
    }
}
