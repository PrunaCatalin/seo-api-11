<?php

namespace Modules\Tenants\App\Rules\Customer;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DomainRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', $value)) {
            $fail('The ' . $attribute . ' must be a valid domain.');
        }
    }
}
