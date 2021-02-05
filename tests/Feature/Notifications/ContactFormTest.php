<?php


namespace Tests\Feature\Notifications;


use App\Notifications\ContactMessage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function submitted_contact_form_sends_notification_to_admins()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->state('admin')->create();

        $respone = $this->asGuest()->post("/contact", [
            "name" => 'test name',
            'email' => 'test@test.test',
            'message' => 'test message',
        ]);
        $respone->assertSuccessful();

        Notification::assertSentTo(
            $admin,
            ContactMessage::class,
            function(ContactMessage $notification, $channels) {
                $this->assertSame('test name', $notification->sender_name);
                $this->assertSame('test@test.test', $notification->sender_email);
                $this->assertSame('test message', $notification->message_body);
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));
                return true;
            }
        );
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => '']);
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_email()
    {
        $this->assertFieldIsInvalid(['email' => '']);
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_message_is_required()
    {
        $this->assertFieldIsInvalid(['message' => '']);
    }

    private function assertFieldIsInvalid($field)
    {
        Notification::fake();

        $valid = [
            "name" => 'test name',
            'email' => 'test@test.test',
            'message' => 'test message',
        ];

        $respone = $this->asGuest()->from("/contact-form")->post("/contact", array_merge($valid, $field));
        $respone->assertRedirect("/contact-form");
        $respone->assertSessionHasErrors(array_key_first($field));
    }
}
