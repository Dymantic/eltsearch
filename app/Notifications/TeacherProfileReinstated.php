<?php

namespace App\Notifications;

use App\Teachers\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeacherProfileReinstated extends Notification implements ActionableNotification
{
    use Queueable;


    public function __construct(public Teacher $teacher)
    {}


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.teachers.profile-reinstated', [
            'body' => $this->getMessageFor($notifiable),
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
        return 'Your profile has been reinstated';
    }

    public function getMessageFor($notifiable): string
    {
        return 'Your profile at ELT Search has been reinstated. Good luck with your job search.';
    }

    public function actionTextFor($notifiable): string
    {
        return '';
    }

    public function actionUrl($notifiable): string
    {
        return '';
    }
}
