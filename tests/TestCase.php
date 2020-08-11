<?php

namespace Tests;

use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asGuest(): self
    {
        $this->assertGuest();

        return $this;
    }

    public function asAdmin(): self
    {
        $this->actingAs(factory(User::class)->state('admin')->create());

        return $this;
    }

    public function setUpSchool()
    {
        $school = factory(School::class)->create();
        $owner = factory(User::class)->state('school')->create();
        $school->setOwner($owner);

        return [$school, $owner];
    }
}
