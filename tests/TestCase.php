<?php

namespace Tests;

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
}
