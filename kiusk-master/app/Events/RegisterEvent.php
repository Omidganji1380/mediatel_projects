<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $role;
    public $via;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $role = 'customer', $via = 'Website')
    {
        $this->user = $user;
        $this->role = $role;
        $this->via = $via;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
