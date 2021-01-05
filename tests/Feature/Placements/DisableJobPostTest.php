<?php


namespace Tests\Feature\Placements;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DisableJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function disable_a_job_post()
    {
        Notification::fake();
        $this->withoutExceptionHandling();


    }
}
