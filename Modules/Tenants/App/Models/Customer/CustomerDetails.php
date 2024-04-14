<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Customer;

use Carbon\Carbon;
use Database\Factories\CustomerDetailsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerDetails
 *
 * @property int $customer_id
 * @property string $name
 * @property string $lastname
 * @property string|null $date_of_birth
 * @property string $phone
 * @property bool $gender
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Customer $customer
 *
 * @package Modules\Tenants\Models
 */
class CustomerDetails extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'customer_details';
    public $incrementing = false;

    protected $casts = [
        'customer_id' => 'int',
        'gender' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'name',
        'lastname',
        'date_of_birth',
        'phone',
        'gender'
    ];

    public static function newFactory()
    {
        return CustomerDetailsFactory::new();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
