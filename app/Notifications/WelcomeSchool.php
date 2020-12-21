<?php

namespace App\Notifications;

use App\Schools\School;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeSchool extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;

    protected $trans_key = 'notifications.welcome_school.';


    public function __construct(public User $owner, public School $school)
    {
    }

    protected function transKeyFor($field): string
    {
        return sprintf("%s%s", $this->trans_key, $field);
    }

    private function ownerLang()
    {
        return $this->owner->preferred_lang ?? 'en';
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.schools.welcome', [
                'body'         => $this->getMessageFor($notifiable),
                'action'       => $this->actionTextFor($notifiable),
                'url'          => $this->actionUrl($notifiable),
                'extra_fields' => []
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'requires_translation' => true,
            'subject' => [
                'text' => $this->transKeyFor('subject'),
                'params' => [],
            ],
            'message' => [
                'text' => $this->transKeyFor('message'),
                'params' => ['name' => $this->owner->name, 'school' => $this->school->name],
            ],
            'action' => ['text' => $this->transKeyFor('action'), 'params' => []],
            'action_url' => $this->actionUrl($notifiable),
            'extra_fields' => []
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
        return trans($this->transKeyFor('subject'), [], $this->ownerLang());
    }

    public function getMessageFor($notifiable): string
    {
        return trans(
            $this->transKeyFor('message'),
            ['name' => $this->owner->name, 'school' => $this->school->name],
            $this->ownerLang()
        );
    }

    public function actionTextFor($notifiable): string
    {
        return trans($this->transKeyFor('action'), [], $this->ownerLang());
    }

    public function actionUrl($notifiable): string
    {
        return url("/schools#/");
    }
}
