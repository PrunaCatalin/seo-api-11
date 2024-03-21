<?php

namespace Modules\Tenants\App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerContactConfirmationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     * @param array $data
     * @param Customer $customer
     */
    public function __construct(protected readonly array $data, protected readonly Customer $customer)
    {
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return
            $this->from(
                config('tenants.contactEmail'),
                config('tenants.contactName')
            )->subject('Contact Request Received')
                ->view(
                    view: 'tenants::notifications.admin.admin-notification',
                    data: ['data' => $this->data, 'customer' => $this->customer]
                );
    }
}
