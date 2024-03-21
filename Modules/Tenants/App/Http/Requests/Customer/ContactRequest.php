<?php

/*
 * ${PROJECT_NAME} | ContactRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11.03.2024 17:43
*/

namespace Modules\Tenants\App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => 'required|max:100',
            'message' => 'required|max:2000',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
