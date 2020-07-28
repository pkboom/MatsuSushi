<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ReservationComplete implements ShouldBroadcast
{
    use SerializesModels;

    public function broadcastOn()
    {
        return new Channel('matsusushi');
    }
}
