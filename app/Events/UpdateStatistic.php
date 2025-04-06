<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateStatistic implements ShouldBroadcast
{
    use InteractsWithSockets;
    use SerializesModels;
    use Dispatchable;

    /**
     * @param array<string, mixed> $updatedStatistic
     * Create a new event instance.
     */
    public function __construct(
        public array $updatedStatistic,
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
            new Channel('updateStatistic'),
        ];
    }

    /** @return  array<string, mixed> */
    public function broadcastWith(): array
    {
        return [
            'updatedStatistic' => $this->updatedStatistic,
        ];
    }
}
