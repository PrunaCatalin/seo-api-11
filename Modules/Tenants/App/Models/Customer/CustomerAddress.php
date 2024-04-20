<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Customer;

use Carbon\Carbon;
use Database\Factories\CustomerAddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenants\App\Models\Location\GenericCity;
use Modules\Tenants\App\Models\Location\GenericCounty;

/**
 * Class CustomerAddress
 *
 * @property int $id
 * @property int $customer_id
 * @property int $city_id
 * @property int $county_id
 * @property string $person_name
 * @property string $person_lastname
 * @property string $person_phone
 * @property string $person_email
 * @property string $person_street_name
 * @property string|null $person_street_number
 * @property string $person_zip_code
 * @property string|null $person_additional_info
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property GenericCity $generic_city
 * @property GenericCounty $generic_county
 * @property Customer $customer
 *
 * @package Modules\Tenants\Models
 */
class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_addresses';

    protected $casts = [
        'customer_id' => 'int',
        'city_id' => 'int',
        'county_id' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'city_id',
        'county_id',
        'person_name',
        'person_lastname',
        'person_phone',
        'person_email',
        'person_street_name',
        'person_street_number',
        'person_zip_code',
        'person_additional_info'
    ];

    public static function newFactory()
    {
        return CustomerAddressFactory::new();
    }

    public function generic_city()
    {
        return $this->belongsTo(GenericCity::class, 'city_id');
    }

    public function generic_county()
    {
        return $this->belongsTo(GenericCounty::class, 'county_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
}
