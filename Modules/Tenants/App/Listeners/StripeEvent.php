<?php

namespace Modules\Tenants\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Modules\Tenants\App\Emails\InvoiceFinalized;

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
        ['type' => $type, 'data' => $data] = $event->payload;

        if ($type === 'invoice.finalized') {
            // Let's find the relevant user/billable
            $stripeCustomerId = $event->payload['data']['object']['customer'];
            $billable = Cashier::findBillable($stripeCustomerId);

            // Get the Laravel\Cashier\Invoice object
            $invoice = $billable->findInvoice($event->payload['data']['object']['id']);

            // Now we can send the invoice!
            Mail::to($billable)->send(new InvoiceFinalized($invoice));
            Log::info('Webhook invoice to the customer', $event->payload);
        } elseif ($type === 'invoice.payment_succeeded') {
            Log::info('Invoice payment invoice.payment_succeeded');
        } elseif ($type === 'invoice.created') {
            Log::info('Invoice payment invoice.created');
        } elseif ($type === 'charge.dispute.created') {
            // Let's notify our admin about a new dispute
            Log::info('Webhook invoice charge.dispute.created', $event->payload);
        }
    }
}
