<?php


namespace Tests\Unit\Placements;


use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class JobPostPublishingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_complete_job_post_is_ready_for_publication()
    {

        $post = factory(JobPost::class)
            ->state('draft')
            ->create();

        $this->assertTrue($post->fresh()->readyForPublication());
    }

    /**
     * @test
     */
    public function some_posts_are_not_ready_for_publication()
    {
        $this->assertPostNotReadyForPublication(['area_id' => null]);
        $this->assertPostNotReadyForPublication(['school_name' => '']);
        $this->assertPostNotReadyForPublication(['position' => '']);
        $this->assertPostNotReadyForPublication(['description' => '']);
        $this->assertPostNotReadyForPublication(['student_ages' => []]);
        $this->assertPostNotReadyForPublication(['schedule' => []]);
        $this->assertPostNotReadyForPublication(['salary_rate' => '']);
        $this->assertPostNotReadyForPublication(['min_students_per_class' => null]);
        $this->assertPostNotReadyForPublication(['max_students_per_class' => null]);
        $this->assertPostNotReadyForPublication(['contract_length' => '']);
        $this->assertPostNotReadyForPublication(['engagement' => '']);
        $this->assertPostNotReadyForPublication(['hours_per_week' => null]);
    }

    /**
     *@test
     */
    public function can_get_post_required_fields_status()
    {
        $post = factory(JobPost::class)->state('draft')->create([
            'student_ages' => [],
            'contract_length' => '',
            'hours_per_week' => null,
        ]);

        $expected = [
            [
                'label' => 'job_posts.required.area_id',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.school_name',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.position',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.description',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.student_ages',
                'complete' => false,
            ],
            [
                'label' => 'job_posts.required.schedule',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.salary_rate',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.min_students_per_class',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.max_students_per_class',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.contract_length',
                'complete' => false,
            ],
            [
                'label' => 'job_posts.required.engagement',
                'complete' => true,
            ],
            [
                'label' => 'job_posts.required.hours_per_week',
                'complete' => false,
            ],
        ];

        $this->assertSame($expected, $post->requiredFieldsStatus());
    }


    private function assertPostNotReadyForPublication($fields)
    {
        $post = factory(JobPost::class)
            ->state('draft')
            ->create($fields);

        $this->assertFalse($post->fresh()->readyForPublication());
    }
}
