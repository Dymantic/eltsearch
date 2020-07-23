<?php


namespace Tests\Unit\Locations;


use App\Locations\Area;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreasTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_rename_an_area()
    {
        $area = factory(Area::class)->create();
        $new_name = new Translation(['en' => "new area name", 'zh' => "zh new area name"]);

        $area->rename($new_name);

        $this->assertSame('new area name', $area->fresh()->name->in('en'));
        $this->assertSame('zh new area name', $area->fresh()->name->in('zh'));

    }
}
