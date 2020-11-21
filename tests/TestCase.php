<?php

namespace Tests;

use App\Placements\JobPost;
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

    public function asJson($array, $column)
    {
        return function ($query) use ($column, $array) {
            $query->select($column);
            foreach ($array as $key => $value) {
                $col = is_string($key) ? "{$column}->{$key}" : $column;
                $query->whereJsonContains($col, $value);
            }
        };
    }
}
