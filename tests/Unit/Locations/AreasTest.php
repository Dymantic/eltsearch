<?php


namespace Tests\Unit\Locations;


use App\Locations\Area;
use App\Locations\Country;
use App\Locations\Region;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_rename_an_area()
    {
        $area = factory(Area::class)->create();
        $new_name = new Translation(['en' => "new area name", 'zh' => "zh new area name"]);

        $area->rename($new_name);

        $this->assertSame('new area name', $area->fresh()->name->in('en'));
        $this->assertSame('zh new area name', $area->fresh()->name->in('zh'));

    }

    /**
     * @test
     */
    public function can_present_full_area_name_for_lang()
    {
        $country = factory(Country::class)->create([
            'name' => new Translation([
                'en' => "test country",
                'zh' => "zh test country"
            ])
        ]);
        $region = factory(Region::class)->create([
            'country_id' => $country->id,
            'name' => new Translation([
                'en' => "test region",
                'zh' => "zh test region"
            ])
        ]);
        $area = factory(Area::class)->create([
            'region_id' => $region->id,
            'name' => new Translation([
                'en' => "test area",
                'zh' => "zh test area"
            ])
        ]);

        $this->assertSame('test area, test region, test country', $area->fullName('en'));
        $this->assertSame('zh test area, zh test region, zh test country', $area->fullName('zh'));
    }
}
