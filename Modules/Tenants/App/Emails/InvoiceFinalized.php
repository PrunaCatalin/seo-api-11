<?php

namespace Modules\Tenants\App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Invoice;

class InvoiceFinalized extends Mailable
{
    use Queueable;
    use SerializesModels;

    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Invoice $invoice
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your invoice is ready',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'tenants::notifications.customer.invoices.finalized',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        Log::debug('Invoice params', (array)($this->invoice));
        return [
            Attachment::fromData(
                data: fn() => $this->invoice->pdf([
                    'vendor' => config('company.company_name'),
                    'product' => 'Seo Marketing Service',
                    'street' => config('company.company_street'),
                    'location' => config('company.company_location'),
                    'phone' => config('company.company_phone'),
                    'email' => 'contact@premium-traffic.com',
                    'url' => 'https://premium-traffic.com',
                    'vendorVat' => config('company.company_vat'),
                ]),
                name: 'invoice.pdf'
            )
        ];
    }
}
