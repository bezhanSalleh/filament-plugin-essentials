<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Resource\Concerns;

use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;

trait HasGlobalSearch
{
    use DelegatesToPlugin;

    /**
     * Check if the resource is globally searchable.
     */
    public static function canGloballySearch(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'isGloballySearchable',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('canGloballySearch') ?? true;
    }

    /**
     * Get the global search results limit.
     */
    public static function getGlobalSearchResultsLimit(): int
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'getGlobalSearchResultsLimit',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return (int) $pluginResult;
        }

        return static::getParentResult('getGlobalSearchResultsLimit') ?? 50;
    }

    /**
     * Check if global search should be case insensitive.
     */
    public static function isGlobalSearchForcedCaseInsensitive(): ?bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'isGlobalSearchForcedCaseInsensitive',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('isGlobalSearchForcedCaseInsensitive');
    }

    /**
     * Check if global search terms should be split.
     */
    public static function shouldSplitGlobalSearchTerms(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'shouldSplitGlobalSearchTerms',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('shouldSplitGlobalSearchTerms') ?? false;
    }
}
