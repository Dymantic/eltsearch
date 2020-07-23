<?php


namespace Tests\Unit\Schools;


use App\Locations\Area;
use App\Schools\School;
use App\Schools\SchoolProfileInfo;
use App\Schools\SchoolType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_update_a_school_profile()
    {
        $school = factory(School::class)->create();

        $area = factory(Area::class)->create();
        $kindergarten = factory(SchoolType::class)->state('kindergarten')->create();
        $elementary = factory(SchoolType::class)->state('elementary')->create();

        $profileInfo = new SchoolProfileInfo([
            'name' => 'new name',
            'introduction' => 'new introduction',
            'school_types' => [$kindergarten->id, $elementary->id],
            'area_id' => $area->id,
        ]);

        $school->updateProfile($profileInfo);

        $school->refresh();

        $this->assertSame('new name', $school->name);
        $this->assertSame('new introduction', $school->introduction);
        $this->assertSame($area->id, $school->area_id);

        $this->assertCount(2, $school->fresh()->schoolTypes);
        $this->assertTrue($school->fresh()->schoolTypes->contains($kindergarten));
        $this->assertTrue($school->fresh()->schoolTypes->contains($elementary));
    }
}
