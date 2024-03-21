<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Location;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GenericCountry
 *
 * @property int $id
 * @property string $name
 * @property string $alpha_2
 * @property string $alpha_3
 * @property string $country_code
 * @property string $iso_3166_2
 * @property string $region
 * @property string $sub_region
 * @property string $intermediate_region
 * @property string $region_code
 * @property string $sub_region_code
 * @property string $intermediate_region_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|GenericCounty[] $generic_counties
 *
 * @package Modules\Tenants\Models
 */
class GenericCountry extends Model
{
    use SoftDeletes;

    protected $table = 'generic_countries';

    protected $fillable = [
        'name',
        'alpha_2',
        'alpha_3',
        'country_code',
        'iso_3166_2',
        'region',
        'sub_region',
        'intermediate_region',
        'region_code',
        'sub_region_code',
        'intermediate_region_code'
    ];

    public function generic_counties()
    {
        return $this->hasMany(GenericCounty::class, 'country_id');
    }
}
