<?php
/*
 * ${PROJECT_NAME} | CheckoutRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 18.04.2024 17:42
*/

namespace Modules\Tenants\App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'planId' => ['required', 'int'],
            'paymentMethodId' => ['required', 'int'],
            'frequency' => ['required', 'string', 'in:year,month'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
