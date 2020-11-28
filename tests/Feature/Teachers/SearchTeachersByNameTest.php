<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTeachersByNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_search_for_teachers_with_a_given_name()
    {
        $this->withoutExceptionHandling();

        factory(Teacher::class)->create(['name' => 'Test teacher']);
        factory(Teacher::class)->create(['name' => 'tEsTing teacher']);
        factory(Teacher::class)->create(['name' => 'unwanted teacher']);

        $response = $this->asAdmin()->getJson("/api/admin/teachers?q=test");
        $response->assertSuccessful();

        $this->assertCount(2, $response->json('items'));

        collect($response->json('items'))
            ->each(
                fn($teacher) => $this->assertNotSame('unwanted teacher', $teacher['name'])
            );
    }
}
