<?php

namespace App\Notifications;

use App\Schools\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolProfileDisabled extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;

    protected string $trans_key = 'notifications.school_disabled.';


    public function __construct(public School $school)
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
            ->markdown('email.schools.profile-disabled', ['body' => $this->getMessageFor($notifiable)]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
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
            'requires_translation' => true,
            'subject'              => [
                'text'   => $this->transKeyFor('subject'),
                'params' => [],
            ],
            'message'              => [
                'text'   => $this->transKeyFor('message'),
                'params' => [
                    'name'   => $notifiable->name,
                    'school' => $this->school->name,
                ],
            ],
            'action'               => ['text' => $this->actionTextFor($notifiable), 'params' => []],
            'action_url'           => $this->actionUrl($notifiable),
            'extra_fields'         => []
        ];
    }

    protected function transKeyFor($field): string
    {
        return sprintf("%s%s", $this->trans_key, $field);
    }

    private function lang($notifiable)
    {
        return $notifiable->preferred_lang ?? 'en';
    }

    public function getSubjectFor($notifiable): string
    {
        return trans($this->transKeyFor('subject'), [], $this->lang($notifiable));
    }

    public function getMessageFor($notifiable): string
    {
        return trans($this->transKeyFor('message'), ['name' => $notifiable->name, 'school' => $this->school->name],
            $this->lang($notifiable));
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
