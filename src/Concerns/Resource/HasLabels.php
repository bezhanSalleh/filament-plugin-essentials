<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

use Filament\Resources\Resource\Concerns\HasLabels as FilamentHasLabels;

trait HasLabels
{
    use DelegatesToPlugin;
    use FilamentHasLabels {
        getModelLabel as filamentGetModelLabel;
        getPluralModelLabel as filamentGetPluralModelLabel;
        getRecordTitleAttribute as filamentGetRecordTitleAttribute;
        hasTitleCaseModelLabel as filamentHasTitleCaseModelLabel;
    }

    public static function getModelLabel(): string
    {
        $pluginResult = static::delegateToPlugin('HasLabels', 'getModelLabel');

        if (! static::isNoPluginResult($pluginResult) && $pluginResult !== null) {
            return $pluginResult;
        }

        return static::filamentGetModelLabel();
    }

    public static function getPluralModelLabel(): string
    {
        $pluginResult = static::delegateToPlugin('HasLabels', 'getPluralModelLabel');

        if (! static::isNoPluginResult($pluginResult) && $pluginResult !== null) {
            return $pluginResult;
        }

        return static::filamentGetPluralModelLabel();
    }

    public static function getRecordTitleAttribute(): ?string
    {
        $pluginResult = static::delegateToPlugin('HasLabels', 'getRecordTitleAttribute');

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::filamentGetRecordTitleAttribute();
    }

    public static function hasTitleCaseModelLabel(): bool
    {
        $pluginResult = static::delegateToPlugin('HasLabels', 'hasTitleCaseModelLabel');

        if (! static::isNoPluginResult($pluginResult)) {
            return $pluginResult;
        }

        return static::filamentHasTitleCaseModelLabel();
    }
}
