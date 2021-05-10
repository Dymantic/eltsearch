<?php

namespace Tests;

use App\Placements\JobPost;
use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mcamara\LaravelLocalization\LaravelLocalization;

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

    public function setUpSchool($school_data = [], $owner_data = [])
    {
        $school = factory(School::class)->create($school_data);
        $owner = factory(User::class)->state('school')->create($owner_data);
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

    protected function refreshApplicationWithLocale($locale)
    {
        self::tearDown();
        putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
        self::setUp();
    }

    protected function tearDown(): void
    {
        putenv(LaravelLocalization::ENV_ROUTE_KEY);
        parent::tearDown();
    }
}
