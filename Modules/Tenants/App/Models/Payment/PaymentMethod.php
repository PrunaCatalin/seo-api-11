<?php
/*
 * ${PROJECT_NAME} | PaymentMethod.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 18.04.2024 15:33
*/

namespace Modules\Tenants\App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'provider', 'configurations', 'is_active'];

    protected $casts = [
        'configurations' => 'array',
    ];

    public function getConfigurationsAttribute($value)
    {
        return json_decode(Crypt::decrypt($value), true);
    }

    public function setConfigurationsAttribute($value)
    {
        $this->attributes['configurations'] = Crypt::encrypt(json_encode($value));
    }
}
