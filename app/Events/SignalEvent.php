<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignalEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $signalData;
    public $fromUser;
    public $toUser;

    public function __construct($signalData, $fromUser, $toUser)
    {
        $this->signalData = $signalData;
        $this->fromUser = $fromUser;
        $this->toUser = $toUser;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat.'.$this->toUser);
    }

    public function broadcastWith()
    {
        return [
            'signalData' => $this->signalData,
            'fromUser' => $this->fromUser,
        ];
    }
}