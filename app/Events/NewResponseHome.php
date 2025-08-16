<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewResponseHome implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    private $hash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, $hash) {
        $this->data = $data;
        $this->hash = $hash;
    }

    // // broadcast condition
    // public function broadcastWhen() {
    //     return md5(request()->ip() . request()->userAgent() . '1') === $this->hash;
    // }

    // Get the channels the event should broadcast on.
    public function broadcastOn() {
        return new Channel('newResponseHomeChannel.' . $this->hash);
    }
}
