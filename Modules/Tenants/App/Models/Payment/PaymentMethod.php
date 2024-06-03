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
use Modules\Tenants\App\Models\Location\GenericCountry;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'configurations',
        'is_active',
        'is_sandbox',
        'country_id',
        'payment_method_id'
    ];


    public function genericCountry()
    {
        return $this->belongsTo(GenericCountry::class, 'country_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function getConfigurationsAttribute()
    {
        if (!empty($this->attributes['configurations'])) {
            $decrypted = Crypt::decrypt($this->attributes['configurations']);
            $decoded = json_decode($decrypted, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        return [];
    }


    public function setConfigurationsAttribute($value)
    {

        $this->attributes['configurations'] = Crypt::encrypt($value);
//        dd($this->attributes);
    }

    public function scopeisActive($query)
    {
        return $query->where('is_active', 1);
    }

}
