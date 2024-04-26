<?php

namespace Modules\Tenants\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEvent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        Log::info('Webhook event received', $event->payload);
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            Log::info('Invoice payment succeeded event handled');
        }

        ['type' => $type, 'data' => $data] = $event->payload;

        if ($type === 'invoice.finalized') {
            // Let's send the invoice to the customer
            Log::info('Webhook invoice to the customer', $event->payload);
        } else {
            if ($type === 'charge.dispute.created') {
                // Let's notify our admin about a new dispute
                Log::info('Webhook invoice charge.dispute.created', $event->payload);
            }
        }
    }
}
