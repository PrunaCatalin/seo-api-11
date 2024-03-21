<?php

namespace App\Models\Scopes;

use App\Services\Tenant\Tenancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        //
        $tenant = app(Tenancy::class)->getTenant();
        if ($tenant) {
            $builder->where('tenant_id', $tenant->id);
        }
    }
}
