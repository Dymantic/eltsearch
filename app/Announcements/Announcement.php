<?php

namespace App\Announcements;

use App\DateFormatter;
use App\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{

    const PUBLIC = 'public';
    const FOR_SCHOOLS = 'schools';
    const FOR_TEACHERS = 'teachers';

    protected $fillable = ['body', 'starts', 'ends', 'type', 'urgent'];

    protected $casts = [
        'body'   => Translation::class,
        'starts' => 'date',
        'ends'   => 'date',
        'urgent' => 'boolean',
    ];

    public static function forPublic(AnnouncementInfo $info): self
    {
        return self::create(array_merge($info->toArray(), ['type' => self::PUBLIC]));
    }

    public static function forSchools(AnnouncementInfo $info): self
    {
        return self::create(array_merge($info->toArray(), ['type' => self::FOR_SCHOOLS]));
    }

    public static function forTeachers(AnnouncementInfo $info): self
    {
        return self::create(array_merge($info->toArray(), ['type' => self::FOR_TEACHERS]));
    }

    public function isCurrent(): bool
    {
        return $this->starts->lessThanOrEqualTo(now()) && $this->ends->isAfter(now());
    }

    public function isUpcoming(): bool
    {
        return $this->starts->isFuture();
    }

    public static function currentPublic($lang): array
    {
        return self::currentOfType(self::PUBLIC, $lang);
    }

    public static function currentSchools($lang): array
    {
        return self::currentOfType(self::FOR_SCHOOLS, $lang);
    }

    public static function currentTeachers($lang): array
    {
        return self::currentOfType(self::FOR_TEACHERS, $lang);
    }

    private static function currentOfType($type, $lang): array
    {
        $announcement = self::latest()
                            ->where('starts', '<=', now()->endOfDay())
                            ->where('type', $type)
                            ->where('ends', '>=', now()->startOfDay())
                            ->first();

        if(!$announcement) {
            return ['', false];
        }

        return [Str::markdown($announcement->body->in($lang)), $announcement->urgent];
    }

    public function toArray()
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'body'        => $this->body->toArray(),
            'body_formatted' => [
                'en' => Str::markdown($this->body->in('en')),
                'zh' => Str::markdown($this->body->in('zh')),
            ],
            'starts'      => DateFormatter::pretty($this->starts),
            'starts_raw'  => DateFormatter::standard($this->starts),
            'ends'        => DateFormatter::pretty($this->ends),
            'ends_raw'    => DateFormatter::standard($this->ends),
            'dates'       => DateFormatter::range($this->starts, $this->ends),
            'is_current'  => $this->isCurrent(),
            'is_upcoming' => $this->isUpcoming(),
            'is_urgent' => $this->urgent,
        ];
    }
}
