<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessage extends Notification implements ShouldQueue, ActionableNotification
{
    use Queueable;


    public function __construct(public string $sender_name, public string $sender_email, public string $message_body)
    {}


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->getSubjectFor($notifiable))
                    ->markdown('email.admin.contact-message', [
                        'sender_name' => $this->sender_name,
                        'sender_email' => $this->sender_email,
                        'message_body' => $this->message_body,
                        'url' => $this->actionUrl($notifiable),
                        'action' => $this->actionTextFor($notifiable),
                    ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'requires_translation' => false,
            'subject' => [
                'text' => $this->getSubjectFor($notifiable),
            ],
            'message' => [
                'text' => $this->getMessageFor($notifiable)
            ],
            'action' => ['text' => $this->actionTextFor($notifiable)],
            'action_url' => $this->actionUrl($notifiable),
            'extra_fields' => [],
            'sender' => $this->sender(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function sender(): string
    {
        return $this->sender_name;
    }

    public function getSubjectFor($notifiable): string
    {
        return sprintf("Contact message from %s", $this->sender_name);
    }

    public function getMessageFor($notifiable): string
    {
        return $this->message_body;
    }

    public function actionTextFor($notifiable): string
    {
        return 'Reply';
    }

    public function actionUrl($notifiable): string
    {
        return sprintf("mailto:%s", $this->sender_email);
    }
}
