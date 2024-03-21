<?php
/**
 * File Name: GetCitiesRequest.php
 * Author: CATALIN PRUNA
 * Created: 7/20/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date         | Author         | Description
 * 7/20/2023 | CATALIN PRUNA | Initial version
 *
 */

namespace Modules\Tenants\App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class GetCitiesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_county' => 'required|numeric'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
