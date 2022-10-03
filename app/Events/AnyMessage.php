<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnyMessage implements ShouldBroadcast

{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $sender;
    protected $targetID;
    protected $message;
    protected $date;
    public function __construct($sender, $targetID, $message)
    {
        $this->sender = $sender;
        $this->targetID = $targetID;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("any-message-{$this->targetID}");
    }
    public function broadcastAs()
    {
        return 'AnyMessage';
    }
    public function broadcastWith(){
        return [
            'sender'=>$this->sender,
            'message'=>$this->message,
            'date'=>now(),
        ];
    }
}
