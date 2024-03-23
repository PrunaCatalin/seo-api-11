<?php

namespace Modules\Tenants\App\Models\Tenant;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $domain
 * @property string $tenant_id
 */
class Domains extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'domains';

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
        'domain',
        'is_ssl',
        'tenant_id',
        'is_active',
        'created_at',
        'updated_at'
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
        'id' => 'int',
        'domain' => 'string',
        'tenant_id' => 'string',
        'is_active' => 'bool',
        'is_ssl' => 'bool',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function getIsActiveAttribute()
    {
        return ($this->attributes['is_active'] === 1) ? trans('active') : trans('inactive ');
    }

    private function isSslAttribute(): string
    {
        return ($this->attributes['is_ssl'] === 1) ? 'https' : 'http';
    }

    public function scopeFullUrl(): string
    {
        return $this->isSslAttribute() . '://www.' . $this->attributes['domain'] . '/';
    }
    // Scopes...

    /**
     * Scope a query to only include active domains.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
    // Functions ...

    // Relations ...
    public function tenant()
    {
        return $this->hasOne(Tenants::class, 'tenant_id', 'id');
    }
}
