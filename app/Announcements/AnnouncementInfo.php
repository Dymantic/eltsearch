<?php


namespace App\Announcements;


use App\Translation;
use Carbon\Carbon;

class AnnouncementInfo
{
    public Translation $body;
    public Carbon $starts;
    public Carbon $ends;
    public bool $urgent;

    public function __construct($info)
    {
        $this->body = new Translation($info['body'] ?? []);
        $this->starts = Carbon::parse($info['starts'] ?? null);
        $this->ends = Carbon::parse($info['ends'] ?? null);
        $this->urgent = $info['urgent'] ?? false;
    }

    public function toArray()
    {
        return [
            'body' => $this->body,
            'starts' => $this->starts,
            'ends' => $this->ends,
            'urgent' => $this->urgent,
        ];
    }
}
