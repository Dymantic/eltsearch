<?php


namespace Tests\Feature\Schools;


use App\Schools\SchoolType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSchoolTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_a_school_type()
    {
        $this->withoutExceptionHandling();

        $type = factory(SchoolType::class)->create();

        $response = $this->asAdmin()->deleteJson("/api/admin/school-types/{$type->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('school_types', ['id' => $type->id]);
    }
}
