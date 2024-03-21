<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Customer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenants\App\Models\Product\Product;

/**
 * Class CustomerWishlist
 *
 * @property int $id
 * @property int $customer_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Customer $customer
 * @property Product $product
 *
 * @package Modules\Tenants\Models
 */
class CustomerWishlist extends Model
{
    use SoftDeletes;

    protected $table = 'customer_wishlist';

    protected $casts = [
        'customer_id' => 'int',
        'product_id' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'product_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
