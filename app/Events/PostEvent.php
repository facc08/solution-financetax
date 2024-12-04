<?php

namespace App\Events;

use App\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  
    public $p;

    public function __construct(Post $p)
    {
        $this->p = $p;
    }

   
    public function broadcastOn()
    {
        return ['channel-post'];
    }

    public function broadcastAs()
    {
        return "event-post";
    }
}
