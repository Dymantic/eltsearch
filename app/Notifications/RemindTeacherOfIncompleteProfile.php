<?php

namespace App\Notifications;

use App\Teachers\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindTeacherOfIncompleteProfile extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;


    public function __construct(public Teacher $teacher)
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
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
            ->markdown('email.teachers.remind-profile-incomplete', [
                'name'   => $this->teacher->name,
                'action' => $this->actionTextFor($notifiable),
                'url'    => $this->actionUrl($notifiable),
            ]);
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

    public function sender(): string
    {
        return 'ELT Search';
    }

    public function getSubjectFor($notifiable): string
    {
        return 'Hey! Let\'s complete your profile.';
    }

    public function getMessageFor($notifiable): string
    {
        return 'You profile is considered incomplete because it is missing one of the following: a profile picture, your teaching experience, your nationality, your age, native language or years of teaching experience. Please complete your profile to make ELTSearch a better opportunity for all.';
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
