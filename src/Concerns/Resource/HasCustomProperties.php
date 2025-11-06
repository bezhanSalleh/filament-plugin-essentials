<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait HasCustomProperties
{
    use DelegatesToPlugin;

    public static function getCustomProperties(): ?array
    {
        $pluginResult = static::delegateToPlugin('HasCustomProperties', 'getCustomProperties');

        if (! static::isNoPluginResult($pluginResult) && $pluginResult !== null) {
            return $pluginResult;
        }

        return static::getParentResult('getCustomProperties');
    }

    public static function getCustomProperty(string $key): mixed
    {
        return static::getCustomProperties()[$key] ?? null;
    }
}
