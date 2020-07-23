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

        $this->assertTrue($school->fresh()->owners->contains($user));
        $this->assertTrue($user->fresh()->schools->contains($school));
    }
}
