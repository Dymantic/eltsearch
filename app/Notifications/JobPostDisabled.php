<?php

namespace App\Notifications;

use App\Placements\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobPostDisabled extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;

    protected $trans_key = 'notifications.job_post_disabled.';


    public function __construct(public JobPost $jobPost)
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
            ->markdown('email.schools.job-post-disabled', [
                'body' => $this->getMessageFor($notifiable)
            ]);
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
                    'name'     => $notifiable->name,
                    'school'   => $this->jobPost->school_name,
                    'position' => $this->jobPost->position,
                ],
            ],
            'action'               => ['text' => $this->actionTextFor($notifiable), 'params' => []],
            'action_url'           => $this->actionUrl($notifiable),
            'extra_fields'         => [],
            'sender'               => $this->sender(),
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


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function getSubjectFor($notifiable): string
    {
        return trans($this->transKeyFor('subject'), [], $this->lang($notifiable));
    }

    public function getMessageFor($notifiable): string
    {
        return trans($this->transKeyFor('message'), [
            'name'     => $notifiable->name,
            'school'   => $this->jobPost->school_name,
            'position' => $this->jobPost->position,
        ], $this->lang($notifiable));
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
