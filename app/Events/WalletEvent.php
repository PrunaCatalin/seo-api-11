<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Services\Customer\WalletService;

class WalletEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $walletData;

    /**
     * Create a new event instance.
     */
    public function __construct(protected readonly WalletService $walletService)
    {
        //
        $user = auth('sanctum')->user();
        $this->walletData = $walletService->getWallet(Customer::find($user->id));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
