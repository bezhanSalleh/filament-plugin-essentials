<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;

trait HasNavigation
{
    use DelegatesToPlugin;

    public static function getNavigationLabel(): string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationLabel',
            null
        );

        return (! static::isNoPluginResult($pluginResult) && filled($pluginResult))
            ? $pluginResult
            : parent::getNavigationLabel();
    }

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationIcon',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationIcon()
            : $pluginResult;
    }

    public static function getActiveNavigationIcon(): BackedEnum | Htmlable | null | string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getActiveNavigationIcon',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getActiveNavigationIcon()
            : $pluginResult;
    }

    public static function getNavigationGroup(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationGroup',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationGroup()
            : $pluginResult;
    }

    public static function getNavigationSort(): ?int
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationSort',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationSort()
            : $pluginResult;
    }

    public static function getNavigationBadge(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationBadge',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationBadge()
            : $pluginResult;
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationBadgeColor',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationBadgeColor()
            : $pluginResult;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationBadgeTooltip',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationBadgeTooltip()
            : $pluginResult;
    }

    public static function shouldRegisterNavigation(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'shouldRegisterNavigation',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::shouldRegisterNavigation()
            : $pluginResult;
    }

    public static function getNavigationParentItem(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationParentItem',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getNavigationParentItem()
            : $pluginResult;
    }

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getSubNavigationPosition',
            null
        );

        return static::isNoPluginResult($pluginResult)
            ? parent::getSubNavigationPosition()
            : $pluginResult;
    }
}
