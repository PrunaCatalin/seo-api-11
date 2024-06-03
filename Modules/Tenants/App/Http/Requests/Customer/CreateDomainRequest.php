<?php
/*
 * ${PROJECT_NAME} | CreateDomainRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 13:35
*/

namespace Modules\Tenants\App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Tenants\App\Rules\Customer\DomainRule;

class CreateDomainRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new DomainRule()]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
