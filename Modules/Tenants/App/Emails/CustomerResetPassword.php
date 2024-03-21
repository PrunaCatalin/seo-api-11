<?php

namespace Modules\Tenants\App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerResetPassword extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $token;
    public string $email;
    public Customer $customer;

    /**
     * Create a new message instance.
     *
     * @param string $token
     * @param string $email
     * @param Customer $customer
     */
    public function __construct(string $token, string $email, Customer $customer)
    {
        $this->token = $token;
        $this->email = $email;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->from(env('MAIL_USERNAME'), env('APP_AUTHOR'))
            ->subject('Reset password')
            ->view(
                view: 'tenants::notifications.reset-email',
                data: [
                    'token' => $this->token,
                    'email' => $this->email,
                    'customer' => $this->customer
                ]
            );
    }
}
