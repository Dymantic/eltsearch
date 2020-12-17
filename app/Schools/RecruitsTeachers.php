<?php


namespace App\Schools;


use App\Exceptions\RecruitmentException;
use App\Notifications\AttemptToRecruit;
use App\Placements\RecruitmentAttempt;
use App\Placements\RecruitmentMessage;
use App\Teachers\Teacher;
use Illuminate\Support\Facades\Notification;

trait RecruitsTeachers
{

    public function attemptToRecruit(Teacher $teacher, RecruitmentMessage $recruitmentMessage): RecruitmentAttempt
    {
        if($this->recentAttemptsFor($teacher) > 2) {
            throw RecruitmentException::tooManyAttempts();
        }

       $attempt = $this
           ->recruitmentAttempts()
           ->create(array_merge(['teacher_id' => $teacher->id], $recruitmentMessage->toArray()));

       Notification::send($teacher->user, new AttemptToRecruit($attempt));

       return $attempt;
    }

    public function recruitmentAttempts()
    {
        return $this->hasMany(RecruitmentAttempt::class);
    }

    protected function recentAttemptsFor(Teacher $teacher): int
    {
        return $this->recruitmentAttempts()
                    ->where('teacher_id', $teacher->id)
                    ->where('created_at', '>=', now()->subDays(60))
                    ->count();
    }
}
