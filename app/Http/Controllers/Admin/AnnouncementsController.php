<?php

namespace App\Http\Controllers\Admin;

use App\Announcements\Announcement;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update($request->announcementInfo()->toArray());
    }

    public function delete(Announcement $announcement)
    {
        $announcement->delete();
    }
}
