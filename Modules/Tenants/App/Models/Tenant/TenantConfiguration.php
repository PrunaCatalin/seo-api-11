<?php

namespace Modules\Tenants\App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Crypt;
use Modules\Tenants\App\Models\Tenants\Domains;

/**
 * @property int $domain_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property string $endpoint
 * @property string $username
 * @property string $password
 * @property string $secret
 * @property string $tenant_type
 */
class TenantConfiguration extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenant_configuration';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id',
        'endpoint',
        'username',
        'password',
        'secret',
        'tenant_type',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'domain_id' => 'int',
        'endpoint' => 'string',
        'username' => 'string',
        'password' => 'string',
        'secret' => 'string',
        'tenant_type' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    //Attributes

    /**
     * @return string
     */
    public function getEndpointAttribute(): string
    {
        return Crypt::decrypt($this->attributes['endpoint']);
    }

    /**
     * @return string
     */
    public function getUsernameAttribute(): string
    {
        return Crypt::decrypt($this->attributes['username']);
    }

    /**
     * @return string
     */
    public function getPasswordAttribute(): string
    {
        return Crypt::decrypt($this->attributes['password']);
    }

    /**
     * @return string
     */
    public function getSecretAttribute(): string
    {
        return Crypt::decrypt($this->attributes['secret']);
    }

    /**
     * @param string $value
     * @return void
     */
    public function setEndpointAttribute(string $value): void
    {
        $this->attributes['endpoint'] = Crypt::encrypt($value);
    }

    /**
     * @param string $value
     * @return void
     */
    public function setUsernameAttribute(string $value): void
    {
        $this->attributes['username'] = Crypt::encrypt($value);
    }

    /**
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Crypt::encrypt($value);
    }

    /**
     * @param string $value
     * @return void
     */
    public function setSecretAttribute(string $value): void
    {
        $this->attributes['secret'] = Crypt::encrypt($value);
    }

    // Scopes...
    // Functions ...

    // Relations ...
    /**
     * @return HasOne
     */
    public function tenant(): HasOne
    {
        return $this->hasOne(Domains::class, "id", "domain_id");
    }
}
