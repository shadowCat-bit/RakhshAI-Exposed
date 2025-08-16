<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewResponse implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    private $uuid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, $uuid) {
        $this->data = $data;
        $this->uuid = $uuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        // return new Channel('newResponseChannel');

        return new PrivateChannel('newResponseChannel.' . $this->uuid);
    }
}
