<?php


namespace Tests\Unit\Schools;


use App\BillingDetails;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Purchasing\ResumePass;
use App\Purchasing\Token;
use App\Schools\School;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SchoolAccountStatusChecksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function checks_for_an_incomplete_profile()
    {
        $schoolA = factory(School::class)->state('incomplete')->create();
        $schoolB = factory(School::class)->create();

        $this->assertContains("incomplete_profile", $schoolA->checkStatus());
        $this->assertNotContains("incomplete_profile", $schoolB->checkStatus());
    }

    /**
     * @test
     */
    public function checks_incomplete_billing_info()
    {
        $complete_billing = new BillingDetails([
            'address' => '123 test address',
            'city'    => 'test city',
            'state'   => 'test state',
            'zip'     => 'test zip',
            'country' => 'test country',
        ]);

        $empty_billing = new BillingDetails([]);

        $schoolA = factory(School::class)->create();
        $schoolB = factory(School::class)->create();

        $schoolA->setBillingDetails($empty_billing);
        $schoolB->setBillingDetails($complete_billing);

        $this->assertContains("incomplete_billing", $schoolA->checkStatus());
        $this->assertNotContains("incomplete_billing", $schoolB->checkStatus());
    }

    /**
     * @test
     */
    public function can_add_school_images_test()
    {
        $schoolA = factory(School::class)->create();
        $schoolB = factory(School::class)->create();

        $schoolB->addImage(UploadedFile::fake()->image('test.png'));
        $schoolB->addImage(UploadedFile::fake()->image('test2.png'));
        $schoolB->addImage(UploadedFile::fake()->image('test3.png'));
        $schoolB->addImage(UploadedFile::fake()->image('test4.png'));

        $this->assertContains("can_add_images", $schoolA->checkStatus());
        $this->assertNotContains("can_add_images", $schoolB->checkStatus());
    }

    /**
     *@test
     */
    public function checks_for_draft_job_posts()
    {
        $school = factory(School::class)->create();
        $school->grantTokens(1,1);

        $job_post = factory(JobPost::class)->state('draft')->create(['school_id' => $school->id]);

        $this->assertContains('has_draft_posts', $school->checkStatus());

        $job_post->publish($school->nextToken());

        $this->assertNotContains('has_draft_posts', $school->checkStatus());
    }

    /**
     *@test
     */
    public function checks_for_no_resume_pass()
    {
        $school = factory(School::class)->create();
        factory(ResumePass::class)->create(['school_id' => $school->id, 'expires_on' => now()->addWeek()]);

        $this->assertNotContains('no_resume_pass', $school->checkStatus());

        $this->travel(10)->days();

        $this->assertContains('no_resume_pass', $school->checkStatus());

    }

    /**
     *@test
     */
    public function checks_for_no_tokens()
    {
        $school = factory(School::class)->create();

        $this->assertContains('no_tokens', $school->checkStatus());

        $school->grantTokens(1,1);
        $this->assertNotContains('no_tokens', $school->checkStatus());
    }

    /**
     *@test
     */
    public function checks_for_new_messages()
    {
        [$school, $owner] = $this->setUpSchool();

        factory(DatabaseNotification::class)->create([
            'notifiable_id' => $owner->id,
            'notifiable_type' => User::class
        ]);

        Auth::login($owner);

        $this->assertContains('has_messages', $school->checkStatus());

        $owner->notifications()->delete();

        $this->assertNotContains('has_messages', $school->checkStatus());
    }

    /**
     *@test
     */
    public function checks_for_recent_applications()
    {
        $school = factory(School::class)->create();
        $post = factory(JobPost::class)->create(['school_id' => $school->id]);

        $this->assertNotContains('has_recent_applications', $school->checkStatus());

        factory(JobApplication::class)->create(['job_post_id' => $post->id]);

        $this->assertContains('has_recent_applications', $school->checkStatus());

        $this->travel(10)->days();

        $this->assertNotContains('has_recent_applications', $school->checkStatus());
    }
}
