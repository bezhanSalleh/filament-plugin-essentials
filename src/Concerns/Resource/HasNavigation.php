<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

trait HasNavigation
{
    use DelegatesToPlugin;

    public static function getNavigationLabel(): string
    {
        return static::pluginOrParent('HasNavigation', 'navigationLabel', 'getNavigationLabel', nullFallsBack: true);
    }

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return static::pluginOrParent('HasNavigation', 'navigationIcon', 'getNavigationIcon');
    }

    public static function getActiveNavigationIcon(): BackedEnum | Htmlable | null | string
    {
        return static::pluginOrParent('HasNavigation', 'activeNavigationIcon', 'getActiveNavigationIcon');
    }

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return static::pluginOrParent('HasNavigation', 'navigationGroup', 'getNavigationGroup');
    }

    public static function getNavigationSort(): ?int
    {
        return static::pluginOrParent('HasNavigation', 'navigationSort', 'getNavigationSort');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::pluginOrParent('HasNavigation', 'navigationBadge', 'getNavigationBadge');
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        return static::pluginOrParent('HasNavigation', 'navigationBadgeColor', 'getNavigationBadgeColor');
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return static::pluginOrParent('HasNavigation', 'navigationBadgeTooltip', 'getNavigationBadgeTooltip');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::pluginOrParent('HasNavigation', 'shouldRegisterNavigation', 'shouldRegisterNavigation', nullFallsBack: true);
    }

    public static function getNavigationParentItem(): ?string
    {
        return static::pluginOrParent('HasNavigation', 'navigationParentItem', 'getNavigationParentItem');
    }

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return static::pluginOrParent('HasNavigation', 'subNavigationPosition', 'getSubNavigationPosition', nullFallsBack: true);
    }
}
