<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPointEvent {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $userId;
    public $pointType;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $userId, $pointType) {
        $this->user = $user;
        $this->userId = $userId;
        $this->pointType = $pointType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
