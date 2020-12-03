<?php


namespace Tests\Feature\Teachers;


use App\Locations\Area;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class SetTeacherBaseLocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_the_area_for_a_teacher()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $area = factory(Area::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/area", [
            'area_id' => $area->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'      => $teacher->id,
            'area_id' => $area->id,
        ]);
    }

    /**
     *@test
     */
    public function the_area_id_must_exist_as_id_in_areas_table()
    {
        $this->assertNull(Area::find(99));

        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/area", [
            'area_id' => 99,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('area_id');
    }
}
