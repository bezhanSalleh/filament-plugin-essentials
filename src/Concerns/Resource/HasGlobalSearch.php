<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait HasGlobalSearch
{
    use DelegatesToPlugin;

    public static function canGloballySearch(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'isGloballySearchable',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::canGloballySearch()
            : $pluginResult;
    }

    public static function isGloballySearchable(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'isGloballySearchable',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::isGloballySearchable()
            : $pluginResult;
    }

    public static function getGlobalSearchResultsLimit(): int
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'getGlobalSearchResultsLimit',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getGlobalSearchResultsLimit()
            : (int) $pluginResult;
    }

    public static function isGlobalSearchForcedCaseInsensitive(): ?bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'isGlobalSearchForcedCaseInsensitive',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::isGlobalSearchForcedCaseInsensitive()
            : $pluginResult;
    }

    public static function shouldSplitGlobalSearchTerms(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasGlobalSearch',
            'shouldSplitGlobalSearchTerms',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::shouldSplitGlobalSearchTerms()
            : $pluginResult;
    }
}
