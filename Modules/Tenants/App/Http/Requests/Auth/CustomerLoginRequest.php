<?php

/**
 * File Name: TenantLoginRequest.php
 * Author: CATALIN PRUNA
 * Created: 7/12/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date         | Author         | Description
 * 7/12/2023 | CATALIN PRUNA | Initial version
 *
 */

namespace Modules\Tenants\App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CustomerLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
