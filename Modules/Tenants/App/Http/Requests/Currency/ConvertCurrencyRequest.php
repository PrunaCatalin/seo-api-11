<?php

/*
 * ${PROJECT_NAME} | ConvertCurrencyRequest.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 02.02.2024 13:13
*/

namespace Modules\Tenants\App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class ConvertCurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Return true to allow all users to make this request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0', // Amount must be a number greater than or equal to 0
            'currency' => 'required|string|max:3|min:3', // Currency code must be a 3-letter string
            'service' => 'nullable|string' // Service is optional but must be a string if provided
        ];
    }
}
