<?php
/*
 * ${PROJECT_NAME} | AuthRequest.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 22:38
*/
namespace Modules\Tenants\App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
