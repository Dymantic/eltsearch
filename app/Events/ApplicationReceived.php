<?php

namespace App\Events;

use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Schools\School;
use App\Teachers\Teacher;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jobApplication;

    public function __construct(JobApplication $application)
    {
        $this->jobApplication = $application;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
