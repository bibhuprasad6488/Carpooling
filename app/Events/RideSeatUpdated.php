<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideSeatUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ride;

    public function __construct($ride)
    {
        $this->ride = $ride;
    }

    public function broadcastOn()
    {
        return new Channel(
            'ride.' . $this->ride->id
        );
    }

    public function broadcastWith()
    {
        return [

            'ride_id' => $this->ride->id,
            'available_seats' =>
            $this->ride->available_seats,
        ];
    }
}
