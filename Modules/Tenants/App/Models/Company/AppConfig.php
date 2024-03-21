<?php

namespace Modules\Tenants\App\Models\Company;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenants\App\Models\Tenants\Domains;

/**
 * @property string $slug
 * @property string $settings
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class AppConfig extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(app(TenantScope::class));
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_config';

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
        'tenant_id',
        'group_name',
        'slug',
        'settings',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
        'settings' => 'string',
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
     * @var bool
     */
    public $timestamps = true;

    // Scopes...

    // Functions ...

    // Relations ...
    public function domain()
    {
        return $this->hasOne(Domains::class, 'id', 'tenant_id');
    }
}
