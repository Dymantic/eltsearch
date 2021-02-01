<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeTeacher extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;


    public function __construct(public User $user)
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
            ->markdown('email.teachers.welcome', [
                'body' => $this->getMessageFor($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'url' => $this->actionUrl($notifiable),
                'extra_fields' => []
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

    public function getSubjectFor($notifiable): string
    {
        return 'Welcome aboard to ELT Search';
    }

    public function getMessageFor($notifiable): string
    {
        return 'Welcome to ELT Search. Start your search today and find the best job for you. Good luck!';
    }

    public function actionTextFor($notifiable): string
    {
        return 'Visit dashboard';
    }

    public function actionUrl($notifiable): string
    {
        return url('/teachers#/');
    }

    public function sender(): string
    {
        return 'ELT Search';
    }
}
