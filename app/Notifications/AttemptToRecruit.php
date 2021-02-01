<?php

namespace App\Notifications;

use App\Placements\RecruitmentAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttemptToRecruit extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;


    public function __construct(public RecruitmentAttempt $recruitmentAttempt)
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
            ->markdown('email.teachers.attempt-to-recruit', [
                'body' => $this->getMessageFor($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'url' => $this->actionUrl($notifiable),
                'school' => $this->recruitmentAttempt->school->name,
                'image' => $this->recruitmentAttempt->school->getLogo(),
                'extra_fields' => [
                    'contact' => $this->recruitmentAttempt->contact_person,
                    'email' => $this->recruitmentAttempt->email,
                    'phone' => $this->recruitmentAttempt->phone,
                ]
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
            'extra_fields' => [
                'contact' => $this->recruitmentAttempt->contact_person,
                'email' => $this->recruitmentAttempt->email,
                'phone' => $this->recruitmentAttempt->phone,
            ],
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
        return sprintf("%s wants you.", $this->recruitmentAttempt->school->name);
    }

    public function getMessageFor($notifiable): string
    {
        return $this->recruitmentAttempt->message;
    }

    public function actionTextFor($notifiable): string
    {
        return 'View Details';
    }

    public function actionUrl($notifiable): string
    {
        return url("teachers#/recruitments/{$this->recruitmentAttempt->id}/details");
    }

    public function sender(): string
    {
        return $this->recruitmentAttempt->school->name;
    }
}
