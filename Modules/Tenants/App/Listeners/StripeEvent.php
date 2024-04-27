<?php

namespace Modules\Tenants\App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Modules\Tenants\App\Emails\AdminPaymentDisputedAlarm;
use Modules\Tenants\App\Emails\InvoiceFinalized;
use Modules\Tenants\App\Models\Customer\Customer;

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
        // Log::info('Webhook event received', $event->payload);
        ['type' => $type, 'data' => $data] = $event->payload;

        if ($type === 'invoice.finalized') {
            // Let's find the relevant user/billable
            $stripeCustomerId = $event->payload['data']['object']['customer'];
            $billable = Cashier::findBillable($stripeCustomerId);

            // Get the Laravel\Cashier\Invoice object
            $invoice = $billable->findInvoice($event->payload['data']['object']['id']);

            // Now we can send the invoice!
            Mail::to($billable)->send(new InvoiceFinalized($invoice));
            //register invoice on system
            Log::info('Webhook invoice to the customer', $event->payload);
        } elseif ($type === 'invoice.payment_succeeded') {
            //charge account
            Log::info('Invoice payment invoice.payment_succeeded');
        } elseif ($type === 'invoice.created') {
            Log::info('Invoice payment invoice.created');
        } elseif ($type === 'charge.dispute.created') {
            Log::info('Invoice payment charge.dispute.created');
            // Let's notify our admin about a new dispute
            $customer = Customer::with('customerDetails')->where(
                'email',
                $event->payload['data']['object']['evidence']['customer_email_address']
            )->first();
            $data = [
                'reason' => $event->payload['data']['object']['reason'],
                'status' => $event->payload['data']['object']['status'],
                'payment_method_details' => $event->payload['data']['object']['payment_method_details']['type'],
                'currency' => $event->payload['data']['object']['currency'],
                'amount' => number_format(
                    ($event->payload['data']['object']['amount'] / 100),
                    2,
                    '.',
                    ' '
                ), //cents
                'dispute_id' => $event->payload['data']['object']['id'],
                'due_by' =>
                    Carbon::parse($event->payload['data']['object']['evidence_details']['due_by'])->toDateTimeString()
            ];
            // Now we can send the dispute alert!
            Mail::to(config('company.company_email'))->send(
                new AdminPaymentDisputedAlarm($data, $customer, 'Stripe')
            );
        } elseif ($type === 'invoice.paid') {
            Log::info('Invoice payment invoice.paid we need credit customer');
        } elseif ($type === 'customer.subscription.deleted') {
            Log::info(
                'Invoice payment customer.subscription.deleted we need refund client and delete active subscription'
            );
        }
    }
}
