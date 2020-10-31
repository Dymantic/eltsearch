<?php


namespace Tests\Feature\Locations;


use App\Locations\Country;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateCountryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_an_existing_country()
    {
        $this->withoutExceptionHandling();

        $country = factory(Country::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => ['en' => "new name", 'zh' => "zh new name"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('countries', [
            'name->en' => "new name",
            'name->zh' => "zh new name"
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_translation()
    {
        $country = factory(Country::class)->create();

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_country_name_must_be_a_unique_translation()
    {
        $country = factory(Country::class)->create();
        factory(Country::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => ['en' => "used name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => ['en' => "unused name", 'zh' => "zh used name"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => ['en' => "USed Name", 'zh' => "ZH Used NAME"],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function can_update_a_single_language_in_the_translation()
    {
        $this->withoutExceptionHandling();
        $country = factory(Country::class)->create([
            'name' => new Translation(['en' => "used name", 'zh' => "zh used name"]),
        ]);

        $response = $this->asAdmin()->postJson("/api/admin/countries/{$country->id}", [
            'name' => ['en' => "used name", 'zh' => "zh unused name"],
        ]);
        $response->assertSuccessful();
    }
}
