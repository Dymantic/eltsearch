<?php

namespace Tests\Feature\Schools;

use App\Locations\Area;
use App\Schools\School;
use App\Schools\SchoolType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateSchoolProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_a_schools_profile()
    {
        $this->withoutExceptionHandling();

        $school = factory(School::class)->state('empty')->create();
        $owner = factory(User::class)->state('school')->create();
        $school->setOwner($owner);

        $location = factory(Area::class)->create();
        $kindergarten = factory(SchoolType::class)->state('kindergarten')->create();
        $elementary = factory(SchoolType::class)->state('elementary')->create();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/", [
            'name'         => 'test name',
            'introduction' => 'test introduction',
            'area_id'      => $location->id,
            'school_types' => [$kindergarten->id, $elementary->id],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('schools', [
            'id'           => $school->id,
            'name'         => 'test name',
            'introduction' => 'test introduction',
            'area_id'      => $location->id,
        ]);

        $this->assertDatabaseHas('school_school_type', [
            'school_id'      => $school->id,
            'school_type_id' => $kindergarten->id,
        ]);

        $this->assertDatabaseHas('school_school_type', [
            'school_id'      => $school->id,
            'school_type_id' => $elementary->id,
        ]);
    }

    /**
     *@test
     */
    public function cannot_update_school_if_not_on_team()
    {
        $schoolA = factory(School::class)->state('empty')->create();
        $schoolB = factory(School::class)->state('empty')->create();
        $owner = factory(User::class)->state('school')->create();
        $schoolA->setOwner($owner);

        $location = factory(Area::class)->create();
        $kindergarten = factory(SchoolType::class)->state('kindergarten')->create();
        $elementary = factory(SchoolType::class)->state('elementary')->create();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$schoolB->id}/", [
            'name'         => 'test name',
            'introduction' => 'test introduction',
            'area_id'      => $location->id,
            'school_types' => [$kindergarten->id, $elementary->id],
        ]);

        $response->assertForbidden();
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => null]);
    }

    /**
     *@test
     */
    public function the_area_id_must_exist_in_the_areas_table()
    {
        $this->assertNull(Area::find(99));

        $this->assertFieldIsInvalid(['area_id' => 99]);
    }

    /**
     *@test
     */
    public function the_school_types_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['school_types' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_school_type_must_exist_as_id_in_school_types_table()
    {
        $this->assertNull(SchoolType::find(99));

        $this->assertFieldIsInvalid(['school_types' => [99]], 'school_types.0');
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $school = factory(School::class)->state('empty')->create();
        $owner = factory(User::class)->state('school')->create();
        $school->setOwner($owner);

        $location = factory(Area::class)->create();
        $kindergarten = factory(SchoolType::class)->state('kindergarten')->create();
        $elementary = factory(SchoolType::class)->state('elementary')->create();

        $valid = [
            'name'         => 'test name',
            'introduction' => 'test introduction',
            'area_id'      => $location->id,
            'school_types' => [$kindergarten->id, $elementary->id],
        ];

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/{$school->id}/", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
