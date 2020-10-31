<?php

namespace Tests\Feature\Locations;

use App\Locations\Country;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateCountryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_new_country()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/api/admin/countries", [
            'name' => ['en' => "test name", 'zh' => "zh test name"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('countries', [
            'name->en' => 'test name',
            'name->zh' => 'zh test name',
        ]);
    }

    /**
     *@test
     */
    public function the_country_name_is_required_in_at_least_one_language()
    {
        $response = $this->asAdmin()->postJson("/api/admin/countries", [
            'name' => ['en' => "", 'zh' => ""],
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_country_name_must_be_unique_in_all_languages()
    {
        factory(Country::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"])
        ]);

        $response = $this->asAdmin()->postJson("/api/admin/countries", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries", [
            'name' => ['en' => "USed Name", 'zh' => "ZH Used NAME"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }
}
