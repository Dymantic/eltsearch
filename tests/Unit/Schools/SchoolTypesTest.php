<?php


namespace Tests\Unit\Schools;


use App\Schools\SchoolType;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolTypesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_make_a_new_school_type()
    {
        $type = SchoolType::new(new Translation(['en' => "test type", 'zh' => "zh test type"]));

        $this->assertInstanceOf(SchoolType::class, $type);
        $this->assertEquals('test type', $type->name->in('en'));
        $this->assertEquals('zh test type', $type->name->in('zh'));
    }

    /**
     *@test
     */
    public function can_be_renamed()
    {
        $type = factory(SchoolType::class)->create();

        $type->rename(new Translation(['en' => "new name", 'zh' => "zh new name"]));

        $this->assertSame('new name', $type->fresh()->name->in('en'));
        $this->assertSame('zh new name', $type->fresh()->name->in('zh'));
    }
}
