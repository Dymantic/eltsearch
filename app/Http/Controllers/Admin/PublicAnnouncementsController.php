<?php

namespace App\Http\Controllers\Admin;

use App\Announcements\Announcement;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\Request;

class PublicAnnouncementsController extends Controller
{
    public function store(AnnouncementRequest $request)
    {
        return Announcement::forPublic($request->announcementInfo());
    }
}
