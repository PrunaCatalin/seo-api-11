<?php

/*
 * ${PROJECT_NAME} | TenantForgotPasswordRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11.03.2024 11:58
*/

namespace Modules\Tenants\App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CustomerForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
