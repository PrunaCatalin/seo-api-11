<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Location;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenants\App\Models\Customer\CustomerAddress;
use Modules\Tenants\App\Models\Customer\CustomerCompany;

/**
 * Class GenericCity
 *
 * @property int $id
 * @property int $county_id
 * @property float $longitude
 * @property float $latitude
 * @property string $name
 * @property string $region
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property GenericCounty $generic_county
 * @property Collection|CustomerAddress[] $customer_addresses
 * @property CustomerCompany $customer_company
 *
 * @package Modules\Tenants\Models
 */
class GenericCity extends Model
{
    use SoftDeletes;

    protected $table = 'generic_cities';

    protected $casts = [
        'county_id' => 'int',
        'longitude' => 'float',
        'latitude' => 'float'
    ];

    protected $fillable = [
        'county_id',
        'longitude',
        'latitude',
        'name',
        'region'
    ];

    public function generic_county()
    {
        return $this->belongsTo(GenericCounty::class, 'county_id');
    }

    public function customer_addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'city_id');
    }

    public function customer_company()
    {
        return $this->hasOne(CustomerCompany::class, 'city_id');
    }
}
