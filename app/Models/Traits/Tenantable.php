<?php

namespace App\Models\Traits;

use App\Models\Scopes\TenantScope;

trait Tenantable
{
    protected static function bootTenantable()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (app()->bound('tenant')) {
                $model->tenant_id = app('tenant')->id;
            }
        });
    }
}
