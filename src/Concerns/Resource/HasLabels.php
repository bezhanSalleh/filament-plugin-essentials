<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait HasLabels
{
    use DelegatesToPlugin;

    public static function getModelLabel(): string
    {
        $pluginResult = static::delegateToPlugin(
            'HasLabels',
            'getModelLabel',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult ?? '';
        }

        return static::getParentResult('getModelLabel') ?? '';
    }

    public static function getPluralModelLabel(): string
    {
        $pluginResult = static::delegateToPlugin(
            'HasLabels',
            'getPluralModelLabel',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult ?? '';
        }

        return static::getParentResult('getPluralModelLabel') ?? '';
    }

    public static function getRecordTitleAttribute(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasLabels',
            'getRecordTitleAttribute',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getRecordTitleAttribute');
    }

    public static function hasTitleCaseModelLabel(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasLabels',
            'hasTitleCaseModelLabel',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('hasTitleCaseModelLabel') ?? true;
    }
}
