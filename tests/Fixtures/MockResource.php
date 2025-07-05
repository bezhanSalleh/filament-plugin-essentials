<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures;

use BezhanSalleh\PluginEssentials\Resource\Concerns;

class MockResource
{
    use Concerns\BelongsToCluster;
    use Concerns\BelongsToParent;
    use Concerns\BelongsToTenant;
    use Concerns\HasGlobalSearch;
    use Concerns\HasLabels;
    use Concerns\HasNavigation;

    protected static $plugin = null;

    public static function pluginEssential(): ?MockPlugin
    {
        return static::$plugin;
    }

    public static function setPlugin(?MockPlugin $plugin): void
    {
        static::$plugin = $plugin;
    }

    // Mock parent methods to simulate Filament's behavior
    public static function getParentResult(string $method): mixed
    {
        return match ($method) {
            'getNavigationLabel' => 'Default Label',
            'getNavigationIcon' => 'heroicon-o-home',
            'getActiveNavigationIcon' => null,
            'getNavigationGroup' => 'Default Group',
            'getNavigationSort' => 1,
            'getNavigationBadge' => null,
            'getNavigationBadgeColor' => 'primary',
            'getNavigationBadgeTooltip' => null,
            'getNavigationParentItem' => null,
            'shouldRegisterNavigation' => true,
            'getSlug' => 'default-slug',
            'getSubNavigationPosition' => null,
            'getModelLabel' => 'Default Model',
            'getPluralModelLabel' => 'Default Models',
            'getCluster' => null,
            'getParentResource' => null,
            'getRecordTitleAttribute' => null,
            'hasTitleCaseModelLabel' => true,
            'isScopedToTenant' => false,
            'getTenantRelationshipName' => null,
            'getTenantOwnershipRelationshipName' => null,
            'canGloballySearch' => true,
            'getGlobalSearchResultsLimit' => 50,
            'isGlobalSearchForcedCaseInsensitive' => null,
            'shouldSplitGlobalSearchTerms' => false,
            default => null,
        };
    }
}
