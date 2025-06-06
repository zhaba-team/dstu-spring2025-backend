<?php

declare(strict_types=1);

namespace App\Events;

use App\DTO\Race\RaceInformationDTO;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnlineRace implements ShouldBroadcast
{
    use InteractsWithSockets;
    use SerializesModels;
    use Dispatchable;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public ?RaceInformationDTO $raceInformation,
    ) {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('onlineRace'),
        ];
    }

    /** @return  array<string, mixed> */
    public function broadcastWith(): array
    {
        return [
            'raceInformation' => $this->raceInformation,
        ];
    }
}
