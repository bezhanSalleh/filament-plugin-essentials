<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Resource\Concerns;

use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;

trait BelongsToParent
{
    use DelegatesToPlugin;

    /**
     * Get the parent resource for this resource.
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
