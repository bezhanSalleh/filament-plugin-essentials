<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Resource\Concerns;

use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;

trait HasLabels
{
    use DelegatesToPlugin;

    /**
     * Get the model label.
     */
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

    /**
     * Get the plural model label.
     */
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

    /**
     * Get the record title attribute.
     */
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

    /**
     * Check if model labels should be title case.
     */
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
