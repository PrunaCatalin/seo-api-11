<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Location;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenants\App\Models\Customer\CustomerAddress;
use Modules\Tenants\App\Models\Customer\CustomerCompany;

/**
 * Class GenericCounty
 *
 * @property int $id
 * @property int $country_id
 * @property string $code
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property GenericCountry $generic_country
 * @property Collection|CustomerAddress[] $customer_addresses
 * @property CustomerCompany $customer_company
 * @property Collection|GenericCity[] $generic_cities
 *
 * @package Modules\Tenants\Models
 */
class GenericCounty extends Model
{
    protected $table = 'generic_county';

    protected $casts = [
        'country_id' => 'int'
    ];

    protected $fillable = [
        'country_id',
        'code',
        'name'
    ];

    public function generic_country()
    {
        return $this->belongsTo(GenericCountry::class, 'country_id');
    }

    public function customer_addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'county_id');
    }

    public function customer_company()
    {
        return $this->hasOne(CustomerCompany::class, 'county_id');
    }

    public function generic_cities()
    {
        return $this->hasMany(GenericCity::class, 'county_id');
    }
}
