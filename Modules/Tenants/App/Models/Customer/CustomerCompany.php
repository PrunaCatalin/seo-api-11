<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Customer;

use Carbon\Carbon;
use Database\Factories\CustomerCompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenants\App\Models\Location\GenericCity;
use Modules\Tenants\App\Models\Location\GenericCounty;

/**
 * Class CustomerCompany
 *
 * @property int $customer_id
 * @property int $city_id
 * @property int $county_id
 * @property string $company_name
 * @property string $prefix_code
 * @property int $cui_code
 * @property string $commerce_reg_letter
 * @property string $county_code
 * @property string $company_year
 * @property string $bank_name
 * @property string $iban_account
 * @property string $company_address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property GenericCity $generic_city
 * @property GenericCounty $generic_county
 * @property Customer $customer
 *
 * @package Modules\Tenants\Models
 */
class CustomerCompany extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'customer_companies';
    public $incrementing = false;

    protected $casts = [
        'customer_id' => 'int',
        'city_id' => 'int',
        'county_id' => 'int',
        'cui_code' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'city_id',
        'county_id',
        'company_name',
        'prefix_code',
        'cui_code',
        'commerce_reg_letter',
        'county_code',
        'company_year',
        'bank_name',
        'iban_account',
        'company_address'
    ];

    public static function newFactory()
    {
        return CustomerCompanyFactory::new();
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
