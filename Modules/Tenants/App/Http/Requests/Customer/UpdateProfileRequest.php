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

use App\Helpers\EnumHelper;
use App\Rules\ValidEnumKeys;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Modules\Tenants\App\Enums\EnumTermsType;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['sometimes', 'date'],
            'gender' => ['required', 'int', 'between:0,1'],
            'phone' => ['string', 'max:20'],
            'type' => ['string', 'in:profile,addresses,domains'],
            'terms' => ['required', 'array', new ValidEnumKeys(EnumTermsType::class)],
            'isNewUser' => ['required', 'bool'],
        ];
    }

    protected function failedValidation($validator)
    {
        Log::error('Validation errors:', $validator->errors()->all());
        parent::failedValidation($validator);
    }

    public function authorize(): bool
    {
        return true;
    }
}
