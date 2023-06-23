<?php

namespace App\Events;

use App\Http\Resources\Marker\MarkerResource;
use App\Models\Marker;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

//class StoreMarkerEvent
class StoreMarkerEvent implements ShouldBroadcast // for broadcasting
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Marker $marker;

    /**
     * Create a new event instance.
     */
    public function __construct(Marker $marker)
    {
        $this->marker = $marker;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('store_marker'),
            //new PrivateChannel('channel-name'),
        ];
    }

    /* from docs */
    public function broadcastAs(): string
    {
        return 'store_marker';
    }

    /* sub name of response object from pusher */
    public function broadcastWith(): array
    {
        return [
            'marker' => MarkerResource::make($this->marker)->resolve(), // used in Index.vue
        ];
    }
}
