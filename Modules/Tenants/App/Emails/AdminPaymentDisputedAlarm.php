<?php

namespace Modules\Tenants\App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Invoice;
use Modules\Tenants\App\Models\Customer\Customer;

class AdminPaymentDisputedAlarm extends Mailable
{
    use Queueable;
    use SerializesModels;

    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected array $data,
        protected Customer $customer,
        protected string $provider
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[System][Alert] - Payment Disputed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'tenants::notifications.admin.admin-payment-disputed',
            with: [
                'data' => $this->data,
                'customer' => $this->customer,
                'provider' => $this->provider
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [

        ];
    }
}
