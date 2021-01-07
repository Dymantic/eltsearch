<?php


namespace App\Placements;


use App\Teachers\Teacher;

class ApplicationApproval
{

    const DISABLED = 'You may not apply for jobs while your profile is disabled';
    const INCOMPLETE_PROFILE = 'Please complete your profile before you post for jobs.';
    const ALREADY_APPLIED = 'You have already applied for this job post';

    public function __construct(
        public bool $can_apply,
        public string $message,
        public int $teacher_id,
        public int $job_post_id,
    ) {
    }

    public static function okay(Teacher $teacher, JobPost $post)
    {
        return new self(true, '', $teacher->id, $post->id);
    }

    public static function disabled(Teacher $teacher, JobPost $post)
    {
        return new self(false, self::DISABLED, $teacher->id, $post->id);
    }

    public static function incomplete(Teacher $teacher, JobPost $post)
    {
        return new self(false, self::INCOMPLETE_PROFILE, $teacher->id, $post->id);
    }

    public static function appliedAlready(Teacher $teacher, JobPost $post)
    {
        return new self(false, self::ALREADY_APPLIED, $teacher->id, $post->id);
    }

    public function toArray(): array
    {
        return [
            'can_apply'   => $this->can_apply,
            'message'     => $this->message,
            'teacher_id'  => $this->teacher_id,
            'job_post_id' => $this->job_post_id,
        ];
    }
}
