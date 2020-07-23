<?php

namespace Test\Unit\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function register_a_teacher()
    {
        $teacher = User::registerTeacher([
            'name' => 'test name',
            'email' => 'test@test.test',
            'password' => 'test_password',
        ]);

        $this->assertEquals('test name', $teacher->name);
        $this->assertEquals('test@test.test', $teacher->email);
        $this->assertTrue(Hash::check('test_password', $teacher->password));
        $this->assertEquals(User::ACCOUNT_TEACHER, $teacher->account_type);
        $this->assertTrue($teacher->isTeacher());
    }

    /**
     *@test
     */
    public function register_a_school()
    {
        $school_admin = User::registerSchool([
            'name' => 'test name',
            'email' => 'test@test.test',
            'password' => 'test_password',
            'school_name' => 'test school',
        ]);

        $this->assertEquals('test name', $school_admin->name);
        $this->assertEquals('test@test.test', $school_admin->email);
        $this->assertTrue(Hash::check('test_password', $school_admin->password));
        $this->assertEquals(User::ACCOUNT_SCHOOL, $school_admin->account_type);
        $this->assertTrue($school_admin->isSchool());

        $this->assertEquals('test school', $school_admin->schools->first()->name);

        $this->assertTrue($school_admin->fresh()->schools->first()->team->owner);
    }
}
