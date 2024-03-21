<?php

/**
 * Created by Reliese Model.
 */

namespace Modules\Tenants\App\Models\Customer;

use App\Models\Scopes\TenantScope;
use App\Traits\HasApiTokensTrait;
use Carbon\Carbon;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Models\Tenant;

/**
 * Class Customer
 *
 * @property int $id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $tenant_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|CustomerAddress[] $customer_addresses
 * @property CustomerCompany $customer_company
 * @property CustomerDetails $customer_detail
 * @property Collection|CustomerWishlist[] $customer_wishlists
 *
 * @package Modules\Tenants\Models
 */
class Customer extends Authentication
{
    use SoftDeletes;
    use HasFactory;
    use HasApiTokensTrait;
    use Notifiable;

    protected $table = 'customers';

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'email',
        'email_verified_at',
        'password',
        'tenant_id',
        'remember_token'
    ];

    public static function newFactory()
    {
        return CustomerFactory::new();
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(app(TenantScope::class));
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customerAddresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function customerCompany()
    {
        return $this->hasOne(CustomerCompany::class);
    }

    public function customerDetails()
    {
        return $this->hasOne(CustomerDetails::class);
    }

    public function customerWishlists()
    {
        return $this->hasMany(CustomerWishlist::class);
    }

    public function customerDomains()
    {
        return $this->hasMany(CustomerDomain::class);
    }
}
