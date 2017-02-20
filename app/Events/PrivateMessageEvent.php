<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateMessageEvent implements ShouldBroadcast {

	use InteractsWithSockets, SerializesModels;

	public $data;

	public function __construct($data) {
		$this->data = $data;
	}


	public function broadcastOn() {
		return new PrivateChannel('user-' . $this->data->to);
	}
}