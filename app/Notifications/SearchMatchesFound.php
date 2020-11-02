<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class SearchMatchesFound extends Notification implements ActionableNotification
{
    use Queueable;



    public Collection $matches;

    public function __construct(Collection $matches)
    {
        $this->matches = $matches;
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function getSubjectFor($notifiable): string
    {
        return 'New Jobs Found';
    }

    public function getMessageFor($notifiable): string
    {
        return "We have matched {$this->matches->count()} new jobs with your latest job search. Visit your dashboard to see more details.";
    }

    public function actionTextFor($notifiable): string
    {
        return 'See Matches';
    }

    public function actionUrl(): string
    {
        return url("teachers#/matches");
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.teachers.search-matches-found', [
                'body' => $this->getMessageFor($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'url' => $this->actionUrl(),

            ]);
    }


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
            'subject' => [
                'text' => $this->getSubjectFor($notifiable),
            ],
            'message' => [
                'text' => $this->getMessageFor($notifiable)
            ],
            'action' => ['text' => $this->actionTextFor($notifiable)],
            'action_url' => $this->actionUrl(),

        ];
    }
}
