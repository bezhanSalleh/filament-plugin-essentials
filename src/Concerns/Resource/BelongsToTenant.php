<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait BelongsToTenant
{
    use DelegatesToPlugin;

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

    public static function getTenantRelationshipName(): string
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToTenant',
            'getTenantRelationshipName',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult ?? '';
        }

        return static::getParentResult('getTenantRelationshipName') ?? '';
    }

    public static function getTenantOwnershipRelationshipName(): string
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToTenant',
            'getTenantOwnershipRelationshipName',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult ?? '';
        }

        return static::getParentResult('getTenantOwnershipRelationshipName') ?? '';
    }
}
