<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

use Filament\Resources\Resource\Concerns\BelongsToTenant as FilamentBelongsToTenant;

trait BelongsToTenant
{
    use FilamentBelongsToTenant {
        isScopedToTenant as filamentIsScopedToTenant;
        getTenantRelationshipName as filamentGetTenantRelationshipName;
        getTenantOwnershipRelationshipName as filamentGetTenantOwnershipRelationshipName;
    }
    use DelegatesToPlugin;

    public static function isScopedToTenant(): bool
    {
        $pluginResult = static::delegateToPlugin('BelongsToTenant', 'shouldScopeToTenant');

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::filamentIsScopedToTenant();
    }

    public static function getTenantRelationshipName(): string
    {
        $fallback = static::filamentGetTenantRelationshipName();

        $pluginResult = static::delegateToPlugin(
            traitName: 'BelongsToTenant',
            methodName: 'getTenantRelationshipName',
            fallback: $fallback
        );

        return $pluginResult;
    }

    public static function getTenantOwnershipRelationshipName(): string
    {
        $pluginResult = static::delegateToPlugin('BelongsToTenant', 'getTenantOwnershipRelationshipName');

        if (! static::isNoPluginResult($pluginResult) && $pluginResult !== null) {
            return $pluginResult;
        }

        return static::filamentGetTenantOwnershipRelationshipName();
    }
}
