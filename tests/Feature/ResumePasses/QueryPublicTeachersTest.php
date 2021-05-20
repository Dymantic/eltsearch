<?php

namespace Tests\Feature\ResumePasses;

use App\Locations\Area;
use App\Nation;
use App\Purchasing\ResumePass;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QueryPublicTeachersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_query_public_teachers()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        list($school, $owner) = $this->setUpSchool();
        factory(ResumePass::class)->create(['school_id' => $school->id]);

        $area_same_regionA = factory(Area::class)->create(['region_id' => $school->area->region->id]);
        $area_same_regionB = factory(Area::class)->create(['region_id' => $school->area->region->id]);
        $area_different_region = factory(Area::class)->create();

        $nationA = factory(Nation::class)->create();
        $nationB = factory(Nation::class)->create();

        $teacherA = factory(Teacher::class)->create([
            'area_id' => $area_same_regionA->id,
            'nation_id' => $nationA->id,
            'years_experience' => 5,
        ]);
        $teacherB = factory(Teacher::class)->create([
            'area_id' => $area_same_regionB->id,
            'nation_id' => $nationA->id,
            'years_experience' => 7,
        ]);
        $teacherC = factory(Teacher::class)->create([
            'area_id' => $area_same_regionA->id,
            'nation_id' => $nationB->id,
            'years_experience' => 5,
        ]);
        $teacherD = factory(Teacher::class)->create([
            'area_id' => $area_different_region->id,
            'nation_id' => $nationA->id,
            'years_experience' => 5,
        ]);
        $teacherE = factory(Teacher::class)->create([
            'area_id' => $area_same_regionA->id,
            'nation_id' => $nationA->id,
            'years_experience' => 1,
        ]);

        collect([$teacherA, $teacherB, $teacherC, $teacherD, $teacherE])
            ->each(function($teacher) {
                $teacher->setAvatar(UploadedFile::fake()->image('test.jpg'));
                $teacher->refresh();
            });

        $url_format = "/api/schools/%s/public-teachers?page=1&near=%s&exp_level=%s&nation=%s&order=name&direction=asc";
        $query = sprintf($url_format, $school->id, $school->area_id, 5, $nationA->id);

        $response = $this->actingAs($owner)->getJson($query);
        $response->assertSuccessful();

        $paged_data = $response->json();
        $queried_teachers = collect($paged_data['items']);
        $this->assertCount(2, $queried_teachers);
        $this->assertTrue($queried_teachers->contains(fn ($t) => $t['email'] === $teacherA->email));
        $this->assertTrue($queried_teachers->contains(fn ($t) => $t['email'] === $teacherB->email));

    }

    /**
     *@test
     */
    public function a_school_with_no_resume_pass_cannot_query_teachers()
    {
        list($school, $owner) = $this->setUpSchool();

        $nationA = factory(Nation::class)->create();


        $url_format = "/api/schools/%s/public-teachers?page=1&near=%s&exp_level=%s&nation=%s&order=name&direction=asc";
        $query = sprintf($url_format, $school->id, $school->area_id, 5, $nationA->id);

        $response = $this->actingAs($owner)->getJson($query);
        $response->assertForbidden();
    }
}
