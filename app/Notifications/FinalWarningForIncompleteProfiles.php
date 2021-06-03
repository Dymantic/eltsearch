<?php

namespace App\Notifications;

use App\Teachers\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinalWarningForIncompleteProfiles extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;


    public function __construct(public Teacher $teacher)
    {}


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.teachers.incomplete-profile-second-warning', [
                'name'   => $this->teacher->name,
                'action' => $this->actionTextFor($notifiable),
                'url'    => $this->actionUrl($notifiable),
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'requires_translation' => false,
            'subject'              => [
                'text' => $this->getSubjectFor($notifiable),
            ],
            'message'              => [
                'text' => $this->getMessageFor($notifiable)
            ],
            'action'               => ['text' => $this->actionTextFor($notifiable)],
            'action_url'           => $this->actionUrl($notifiable),
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
        return 'ELT Search';
    }

    public function getSubjectFor($notifiable): string
    {
        return 'Your profile is still incomplete';
    }

    public function getMessageFor($notifiable): string
    {
        return 'Your profile is still flagged as incomplete. Please complete your profile as soon as possible. ELT Search reserves the right to delete any profiles that remain incomplete over an extended period of time.';
    }

    public function actionTextFor($notifiable): string
    {
        return 'Go to Profile';
    }

    public function actionUrl($notifiable): string
    {
        return url('/teachers#/profile');
    }
}
