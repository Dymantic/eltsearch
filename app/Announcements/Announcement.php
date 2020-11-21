<?php

namespace App\Announcements;

use App\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{

    const PUBLIC = 'public';
    const FOR_SCHOOLS = 'for_schools';
    const FOR_TEACHERS = 'for_teachers';

    protected $fillable = ['body', 'starts', 'ends', 'type'];

    protected $casts = [
        'body' => Translation::class
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
}
