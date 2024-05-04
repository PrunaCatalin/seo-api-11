<?php
/*
 * ${PROJECT_NAME} | AddressRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 03.05.2024 07:44
*/

namespace Modules\Tenants\App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'sometimes|nullable|numeric',
            'perPage' => 'sometimes|nullable|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
