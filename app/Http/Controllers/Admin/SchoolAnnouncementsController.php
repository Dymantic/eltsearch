<?php

namespace App\Http\Controllers\Admin;

use App\Announcements\Announcement;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\Request;

class SchoolAnnouncementsController extends Controller
{
    public function store(AnnouncementRequest $request)
    {
        return Announcement::forSchools($request->announcementInfo());
    }
}
