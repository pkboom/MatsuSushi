<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;

class ReservationComplete
{
    use SerializesModels;

    public function broadcastOn()
    {
        return new Channel('reservations');
    }
}
