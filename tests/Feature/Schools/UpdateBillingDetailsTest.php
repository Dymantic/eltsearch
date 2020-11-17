<?php


namespace Tests\Feature\Schools;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateBillingDetailsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_schools_billing_details()
    {
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/billing-details", [
            'city' => 'Test City',
            'address' => 'test address',
            'zip' => '408',
            'country' => 'TW',
            'state' => ''
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'billing_city' => 'Test City',
            'billing_address' => 'test address',
            'billing_zip' => '408',
            'billing_country' => 'TW',
            'billing_state' => ''
        ]);
    }

    /**
     *@test
     */
    public function cannot_set_billing_details_of_another_school()
    {
        list($school, $owner) = $this->setUpSchool();
        list($other_school, $other_owner) = $this->setUpSchool();

        $response = $this->actingAs($other_owner)->postJson("/api/schools/{$school->id}/billing-details", [
            'city' => 'Test City',
            'address' => 'test address',
            'zip' => '408',
            'country' => 'TW',
            'state' => ''
        ]);
        $response->assertForbidden();
    }

    /**
     *@test
     */
    public function the_city_is_required()
    {
        $this->assertFieldIsInvalid(['city' => null]);
    }

    /**
     *@test
     */
    public function the_country_is_required()
    {
        $this->assertFieldIsInvalid(['country' => null]);
    }

    /**
     *@test
     */
    public function the_zip_code_is_required()
    {
        $this->assertFieldIsInvalid(['zip' => null]);
    }

    /**
     *@test
     */
    public function the_address_is_required()
    {
        $this->assertFieldIsInvalid(['address' => null]);
    }


    private function assertFieldIsInvalid($field)
    {
        list($school, $owner) = $this->setUpSchool();

        $valid = [
            'city' => 'Test City',
            'address' => 'test address',
            'zip' => '408',
            'country' => 'TW',
            'state' => ''
        ];

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/{$school->id}/billing-details", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
