<?php

namespace Tests\Feature\Settings;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class SetPreferredLangTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_preferred_lang_for_a_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->state('school')->create([
            'preferred_lang' => 'en',
        ]);

        $response = $this->actingAs($user)->postJson("/api/preferred-lang", [
            'lang' => 'zh'
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'preferred_lang' => 'zh'
        ]);
    }

    /**
     *@test
     */
    public function the_language_is_required()
    {
        $user = factory(User::class)->state('school')->create([
            'preferred_lang' => 'en',
        ]);

        $response = $this->actingAs($user)->postJson("/api/preferred-lang", [
            'lang' => null
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('lang');
    }

    /**
     *@test
     */
    public function the_lang_must_be_either_en_or_zh()
    {
        $user = factory(User::class)->state('school')->create([
            'preferred_lang' => 'en',
        ]);

        $response = $this->actingAs($user)->postJson("/api/preferred-lang", [
            'lang' => 'fr'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('lang');
    }
}
