<?php

namespace App\Events;

use App\Teachers\Teacher;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeacherProfileDisabled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public Teacher $teacher)
    {}


}
