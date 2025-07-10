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

        if (! static::isNoPluginResult($pluginResult) && filled($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationLabel') ?? '';
    }

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationIcon',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationIcon');
    }

    public static function getActiveNavigationIcon(): BackedEnum | Htmlable | null | string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getActiveNavigationIcon',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getActiveNavigationIcon');
    }

    public static function getNavigationGroup(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationGroup',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationGroup');
    }

    public static function getNavigationSort(): ?int
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationSort',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationSort');
    }

    public static function getNavigationBadge(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationBadge',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationBadge');
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationBadgeColor',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationBadgeColor');
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationBadgeTooltip',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationBadgeTooltip');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'shouldRegisterNavigation',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('shouldRegisterNavigation') ?? true;
    }

    public static function getNavigationParentItem(): ?string
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getNavigationParentItem',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getNavigationParentItem');
    }

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        $pluginResult = static::delegateToPlugin(
            'HasNavigation',
            'getSubNavigationPosition',
            null
        );

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::getParentResult('getSubNavigationPosition') ?? SubNavigationPosition::Start;
    }
}
