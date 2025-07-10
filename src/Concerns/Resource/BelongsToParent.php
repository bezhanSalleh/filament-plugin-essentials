<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait BelongsToParent
{
    use DelegatesToPlugin;

    /**
     * Get the parent forResource for this forResource.
     */
    public static function getParentResource(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'BelongsToParent',
            'getParentResource',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getParentResource');
    }
}
