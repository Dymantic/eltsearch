<?php

namespace Tests\Unit\Schools;

use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_a_new_school_with_name()
    {
        $school = School::new('test name');

        $this->assertInstanceOf(School::class, $school);
        $this->assertSame('test name', $school->name);
        $this->assertNotNull($school->key);
    }

    /**
     *@test
     */
    public function set_owner_for_school()
    {
        $school = factory(School::class)->create();
        $user = factory(User::class)->state('school')->create();

        $school->setOwner($user);

        $this->assertTrue($school->fresh()->admins->contains($user));
        $this->assertTrue($user->fresh()->schools->contains($school));
    }

    /**
     *@test
     */
    public function can_be_scoped_to_signed_up_since_date()
    {
        $too_old = factory(School::class)->create([
            'created_at' => now()->subDays(10)
        ]);
        factory(School::class, 2)->create([
            'created_at' => now()->subDays(5)
        ]);

        $scoped = School::signedUpSince(now()->subDays(7))->get();

        $this->assertCount(2, $scoped);
        $this->assertFalse($scoped->contains($too_old));
    }
}
