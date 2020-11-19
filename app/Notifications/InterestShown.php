<?php

namespace App\Notifications;

use App\ContactDetails;
use App\Placements\ShowOfInterest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterestShown extends Notification implements ActionableNotification
{
    use Queueable;

    public ShowOfInterest $showOfInterest;
    public $jobPost;
    public $school;
    public $application;

    public function __construct(ShowOfInterest $showOfInterest)
    {
        $showOfInterest->load('jobApplication.jobPost.school');
        $this->showOfInterest = $showOfInterest;
        $this->application = $showOfInterest->jobApplication;
        $this->jobPost = $showOfInterest->jobApplication->jobPost;
        $this->school = $showOfInterest->jobApplication->jobPost->school;
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.teachers.interest_shown', [
                'body' => $this->getMessageFor($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'url' => $this->actionUrl($notifiable),
                'image' => $this->school->getLogo(),
                'extra_fields' => [
                    'email' => $this->showOfInterest->email,
                    'phone' => $this->showOfInterest->phone,
                ]
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
            'action_url' => $this->actionUrl($notifiable),
            'extra_fields' => [
                'email' => $this->showOfInterest->email,
                'phone' => $this->showOfInterest->phone,
            ]
        ];
    }

    public function getSubjectFor($notifiable): string
    {
        return 'Response from Job Application';
    }

    public function getMessageFor($notifiable): string
    {
        return sprintf("%s from %s has read your application for %s and would like you to get in touch to take the next steps.", $this->showOfInterest->name, $this->school->name, $this->jobPost->position);
    }

    public function actionTextFor($notifiable): string
    {
        return 'See details';
    }

    public function actionUrl($notifiable): string
    {
        return url("teachers#/applications/{$this->application->id}/show-of-interest");
    }
}
