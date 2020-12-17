<?php

namespace App\Notifications;

use App\Placements\JobPost;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobPostMatchesFound extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;


    public JobPost $jobPost;

    public function __construct(JobPost $jobPost)
    {
        $this->jobPost = $jobPost;
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function getSubjectFor($notifiable): string
    {
        return 'A Job Matches Your Search';
    }

    public function getMessageFor($notifiable): string
    {
        return sprintf('We have found a job that you may be interested in, based on your current job search. The job advertised is for the position of %s with %s, located in %s. See the job post for more details.', $this->jobPost->position, $this->jobPost->school_name, $this->jobPost->area->fullName('en'));
    }

    public function actionTextFor($notifiable): string
    {
        return 'View Job Post';
    }

    public function actionUrl($notifiable): string
    {
        if($notifiable instanceof User && $notifiable->isTeacher()) {
            $match = $notifiable->teacher->jobMatches()->where('job_post_id', $this->jobPost->id)->first();
            return url("teachers#/job-matches/{$match->id}/post");
        }
        return url("teachers#/job-posts/{$this->jobPost->slug}");
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.teachers.job-post-matches-found', [
                'body' => $this->getMessageFor($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'url' => $this->actionUrl($notifiable),
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
            'subject' => [
                'text' => $this->getSubjectFor($notifiable),
            ],
            'message' => [
                'text' => $this->getMessageFor($notifiable)
            ],
            'action' => ['text' => $this->actionTextFor($notifiable)],
            'action_url' => $this->actionUrl($notifiable),

        ];
    }


}
