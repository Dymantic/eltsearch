<?php

namespace App\Notifications;

use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ApplicationReceived extends Notification
{
    use Queueable;

    const TRANS_KEY_BASE = 'notifications.application_received';


    public JobApplication $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public static function transKeyFor($key)
    {
        return sprintf("%s.%s", self::TRANS_KEY_BASE, $key);
    }

    public function teacher(): Teacher
    {
        return $this->jobApplication->teacher;
    }

    public function jobPost(): JobPost
    {
        return $this->jobApplication->jobPost;
    }

    public function getSubjectFor($notifiable)
    {
        return Lang::get(self::transKeyFor('subject'), [
            'name'     => $this->teacher()->name,
            'position' => $this->jobPost()->position,
        ], $notifiable->preferred_lang ?? 'en');
    }

    public function getMessageFor($notifiable)
    {
        return Lang::get(self::transKeyFor('message'), [
            'teacher'  => $this->teacher()->name,
            'position' => $this->jobPost()->position,
            'school'   => $this->jobPost()->school_name,
        ], $notifiable->preferred_lang ?? 'en');
    }

    public function actionUrl($notifiable)
    {
        return url("schools#/applications/{$this->jobApplication->id}");
    }

    public function actionTextFor($notifiable)
    {
        return Lang::get(
            self::transKeyFor('action'), [], $notifiable->preferred_lang ?? 'en'
        );
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.schools.application-received', [
                'body'   => $this->getMessageFor($notifiable),
                'url'    => $this->actionUrl($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'image'  => url($this->teacher()->getAvatar()),
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
            'requires_translation' => true,
            'subject'              => [
                'text'   => self::transKeyFor('subject'),
                'params' => ['position' => $this->jobPost()->position],
            ],
            'message'              => [
                'text'   => self::transKeyFor('message'),
                'params' => [
                    'teacher'  => $this->teacher()->name,
                    'position' => $this->jobPost()->position,
                    'school'   => $this->jobPost()->school_name,
                ]
            ],
            'action'               => [
                'text' => self::transKeyFor('action'),
                'params' => []
            ],
            'action_url'           => $this->actionUrl($notifiable),
        ];
    }
}
