<?php


namespace App\Announcements;


use App\Translation;
use Carbon\Carbon;

class AnnouncementInfo
{
    public Translation $body;
    public Carbon $starts;
    public Carbon $ends;

    public function __construct($info)
    {
        $this->body = new Translation($info['body'] ?? []);
        $this->starts = Carbon::parse($info['starts'] ?? null);
        $this->ends = Carbon::parse($info['ends'] ?? null);
    }

    public function toArray()
    {
        return [
            'body' => $this->body,
            'starts' => $this->starts,
            'ends' => $this->ends,
        ];
    }
}
