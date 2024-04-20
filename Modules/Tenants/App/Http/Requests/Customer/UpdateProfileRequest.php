<?php
/*
 * ${PROJECT_NAME} | UpdateProfileRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 15.04.2024 17:51
*/

namespace Modules\Tenants\App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['sometimes', 'date'],
            'gender' => ['required', 'int', 'between:0,1'],
            'phone' => ['string', 'max:20']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
