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
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Modules\Tenants\App\Enums\Subscription\SubscriptionStatus;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;
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
    use Billable;
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
        'credits',
        'email',
        'email_verified_at',
        'password',
        'tenant_id',
        'referral_id',
        'remember_token',
        'account_status'
    ];


    public static function newFactory()
    {
        return CustomerFactory::new();
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(app(TenantScope::class));

        static::creating(function ($model) {
            $model->referral_id = 'TRFP-' . strtoupper(Str::random(10)) . '-' . time();
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customerAddresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function customerCompanies()
    {
        return $this->hasMany(CustomerCompany::class, 'customer_id');
    }

    public function customerTerms()
    {
        return $this->hasMany(CustomerTerm::class, 'customer_id');
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

    /**
     * The referrals made by this customer.
     */
    public function referralsMade()
    {
        return $this->hasMany(CustomerReferral::class, 'referrer_id');
    }

    /**
     * The referrals where this customer was referred.
     */
    public function referralsReceived()
    {
        return $this->hasMany(CustomerReferral::class, 'referred_id');
    }

    public function currentPlan()
    {
        return $this->subscriptionPlans()
            ->wherePivot('status', '=', SubscriptionStatus::ACTIVE->value)
            ->first();
    }

    public function subscriptionPlans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'customer_subscription_plan')
            ->using(CustomerSubscriptionPlan::class)
            ->withTimestamps()->withPivot(['frequency', 'ended_at', 'status', 'no_domains']);
    }

    public function expiredPlan()
    {
        return $this->subscriptionPlans()
            ->wherePivot('status', '=', SubscriptionStatus::EXPIRED->value)
            ->orderBy('pivot_created_at', 'desc')
            ->first();
    }

    public function canceledPlan()
    {
        return $this->subscriptionPlans()
            ->wherePivot('status', '=', SubscriptionStatus::CANCELED->value)
            ->orderBy('pivot_created_at', 'desc')
            ->first();
    }

    public function canceledByClientPlan()
    {
        return $this->subscriptionPlans()
            ->wherePivot('status', '=', SubscriptionStatus::CANCELED_BY_CLIENT->value)
            ->orderBy('pivot_created_at', 'desc')
            ->first();
    }

    public function nextPlan()
    {
        return $this->subscriptionPlans()
            ->wherePivot('status', '=', SubscriptionStatus::PENDING->value)
            ->first();
    }


}
