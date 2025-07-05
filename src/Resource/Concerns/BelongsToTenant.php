<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Resource\Concerns;

use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;

trait BelongsToTenant
{
    use DelegatesToPlugin;

    /**
     * Check if the resource is scoped to tenant.
     */
    public static function isScopedToTenant(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToTenant',
            'shouldScopeToTenant',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('isScopedToTenant') ?? false;
    }

    /**
     * Get the tenant relationship name.
     */
    public static function getTenantRelationshipName(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToTenant',
            'getTenantRelationshipName',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getTenantRelationshipName');
    }

    /**
     * Get the tenant ownership relationship name.
     */
    public static function getTenantOwnershipRelationshipName(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToTenant',
            'getTenantOwnershipRelationshipName',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getTenantOwnershipRelationshipName');
    }
}
