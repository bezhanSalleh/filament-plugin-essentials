<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait BelongsToTenant
{
    use DelegatesToPlugin;

    public static function isScopedToTenant(): bool
    {
        return static::pluginOrParent('BelongsToTenant', 'isScopedToTenant', 'isScopedToTenant', nullFallsBack: true);
    }

    public static function getTenantRelationshipName(): string
    {
        return static::pluginOrParent('BelongsToTenant', 'tenantRelationshipName', 'getTenantRelationshipName', nullFallsBack: true);
    }

    public static function getTenantOwnershipRelationshipName(): string
    {
        return static::pluginOrParent('BelongsToTenant', 'tenantOwnershipRelationshipName', 'getTenantOwnershipRelationshipName', nullFallsBack: true);
    }
}
