<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait BelongsToCluster
{
    use DelegatesToPlugin;

    public static function getCluster(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToCluster',
            'getCluster',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getCluster');
    }
}
