<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait HasGlobalSearch
{
    use DelegatesToPlugin;

    public static function isGloballySearchable(): bool
    {
        $value = static::resolvePluginProperty('HasGlobalSearch', 'isGloballySearchable');

        return static::isNoPluginResult($value)
            ? static::$isGloballySearchable
            : (bool) $value;
    }

    public static function canGloballySearch(): bool
    {
        $value = static::resolvePluginProperty('HasGlobalSearch', 'isGloballySearchable');

        if (static::isNoPluginResult($value)) {
            return static::getParentResult('canGloballySearch');
        }

        return (bool) $value
            && count(static::getGloballySearchableAttributes()) > 0
            && static::canAccess();
    }

    public static function getGlobalSearchResultsLimit(): int
    {
        return static::pluginOrParent('HasGlobalSearch', 'globalSearchResultsLimit', 'getGlobalSearchResultsLimit', nullFallsBack: true);
    }

    public static function isGlobalSearchForcedCaseInsensitive(): ?bool
    {
        return static::pluginOrParent('HasGlobalSearch', 'isGlobalSearchForcedCaseInsensitive', 'isGlobalSearchForcedCaseInsensitive');
    }

    public static function shouldSplitGlobalSearchTerms(): bool
    {
        return static::pluginOrParent('HasGlobalSearch', 'shouldSplitGlobalSearchTerms', 'shouldSplitGlobalSearchTerms', nullFallsBack: true);
    }
}
