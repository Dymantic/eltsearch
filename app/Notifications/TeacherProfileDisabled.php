<?php

namespace App\Notifications;

use App\Teachers\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeacherProfileDisabled extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;


    public function __construct(public Teacher $teacher)
    {
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.teachers.profile-disabled', [
            'body'   => $this->getMessageFor($notifiable),
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


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function getSubjectFor($notifiable): string
    {
        return 'Your profile has been disabled';
    }

    public function getMessageFor($notifiable): string
    {
        return 'ELT Search has temporarily disabled your profile. If you wish to contest this, you may reach out to the admin team at services@eltsearch.com for further discussion. If your profile remains disabled for 7 days it will be permanently removed.';
    }

    public function actionTextFor($notifiable): string
    {
        return '';
    }

    public function actionUrl($notifiable): string
    {
        return '';
    }

    public function sender(): string
    {
        return 'ELT Search';
    }
}
