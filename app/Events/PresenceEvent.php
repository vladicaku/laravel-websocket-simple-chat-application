<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class PresenceEvent implements ShouldBroadcast {

	use InteractsWithSockets, SerializesModels;

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array
	 */
	public function broadcastOn() {
		// TODO: Implement broadcastOn() method.
	}
}