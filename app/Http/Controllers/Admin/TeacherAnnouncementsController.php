<?php

namespace App\Http\Controllers\Admin;

use App\Announcements\Announcement;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\Request;

class TeacherAnnouncementsController extends Controller
{
    public function store(AnnouncementRequest $request)
    {
        return Announcement::forTeachers($request->announcementInfo());
    }
}
