<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $channelID;
    protected $message;
    protected $sender;
    public function __construct($channelID, $message, $sender)
    {
        $this->channelID = $channelID;
        $this->message = $message;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("message-channel-{$this->channelID}");
    }
    public function broadcastAs()
    {
        return 'SendMessage';
    }
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'sender'=>$this->sender,
        ];
    }
}
